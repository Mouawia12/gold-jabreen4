<?php

namespace App\Services;

use App\Models\CompanyInfo;
use App\Models\ExitWork;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class SimplifiedTaxInvoicePrintService
{
    public function build(int $invoiceId): array
    {
        $invoice = ExitWork::with(['branch', 'company', 'cash', 'visa'])->findOrFail($invoiceId);
        $companyInfo = CompanyInfo::first();

        $details = DB::table('exit_work_details')
            ->join('items', 'items.id', '=', 'exit_work_details.item_id')
            ->join('karats', 'karats.id', '=', 'exit_work_details.karat_id')
            ->select(
                'exit_work_details.*',
                'karats.name_ar as karat_ar',
                'karats.name_en as karat_en',
                'karats.stamp_value as karat_stamp',
                'items.name_ar as item_ar',
                'items.name_en as item_en',
                'items.no_metal',
                'items.no_metal_type',
                'items.tax as item_tax'
            )
            ->where('exit_work_details.bill_id', '=', $invoiceId)
            ->get();

        $items = [];
        $lineNo = 1;
        $karatTotals = [
            24 => 0.0,
            22 => 0.0,
            21 => 0.0,
            18 => 0.0,
        ];

        foreach ($details as $detail) {
            $metalExtra = 0.0;
            if ((int) $detail->no_metal_type === 1) {
                $metalExtra = (float) $detail->no_metal;
            } elseif ((float) $detail->no_metal > 0) {
                $metalExtra = (float) $detail->weight * ((float) $detail->no_metal / 100);
            }

            $subtotalExclVat = (float) $detail->net_money - (float) $detail->gram_tax;
            $vatAmount = (float) $detail->gram_tax;
            $vatRate = (float) $detail->item_tax;
            $totalInclVat = (float) $detail->net_money;

            $items[] = [
                'line_no' => $lineNo,
                'description' => $detail->item_ar ?: $detail->item_en,
                'karat' => $detail->karat_ar ?: $detail->karat_en,
                'karat_value' => $detail->karat_stamp,
                'weight' => (float) $detail->weight,
                'metal_extra' => $metalExtra,
                'gram_price' => (float) $detail->gram_price,
                'qty' => (float) ($detail->count ?: 1),
                'subtotal_excl_vat' => $subtotalExclVat,
                'vat_amount' => $vatAmount,
                'vat_rate' => $vatRate,
                'total_incl_vat' => $totalInclVat,
            ];

            $lineNo++;

            $karatKey = (int) $detail->karat_stamp;
            if (array_key_exists($karatKey, $karatTotals)) {
                $karatTotals[$karatKey] += (float) $detail->weight;
            }
        }

        $totals = $this->calculateTotals($items, (float) $invoice->discount);

        $issuedAt = $invoice->date ?: $invoice->created_at;
        $issuedAt = $issuedAt ? Carbon::parse($issuedAt) : Carbon::now();

        $qrImage = $this->buildQrImage(
            $companyInfo?->name_ar ?? '',
            $companyInfo?->taxNumber ?? '',
            $issuedAt,
            $totals['grand_total'],
            $totals['vat_total']
        );

        $logoPath = $this->resolveLogoPath($companyInfo?->logo);
        $branch = $invoice->branch;

        $cashAmount = (float) ($invoice->cash->amount ?? 0);
        $cardAmount = (float) ($invoice->visa->amount ?? 0);

        $type = 'نقدي';
        if ($cardAmount > 0 && $cashAmount > 0) {
            $type = 'نقدي/شبكة';
        } elseif ($cardAmount > 0) {
            $type = 'شبكة';
        }

        return [
            'company' => [
                'company_ar' => $companyInfo?->name_ar ?? '',
                'company_en' => $companyInfo?->name_en ?? '',
                'tax_number' => $companyInfo?->taxNumber ?? '',
                'commercial_registry' => $companyInfo?->registrationNumber ?? '',
                'mineral_license' => '',
                'address_ar' => $companyInfo?->address ?? '',
                'address_en' => $companyInfo?->address ?? '',
                'phone' => $companyInfo?->phone ?? '',
                'logo_path' => $logoPath,
            ],
            'branch' => [
                'branch_ar' => $branch?->branch_name ?? '',
                'branch_en' => $branch?->branch_name ?? '',
                'branch_address_ar' => $branch?->branch_address ?? '',
                'branch_address_en' => $branch?->branch_address ?? '',
                'branch_phone' => $branch?->branch_phone ?? '',
            ],
            'invoice' => [
                'invoice_no' => (string) $invoice->bill_number,
                'date' => $issuedAt->format('d/m/Y'),
                'time' => $issuedAt->format('H:i:s'),
                'type' => $type,
                'customer_name' => $invoice->bill_client_name ?: ($invoice->company?->name ?? ''),
                'customer_phone' => $invoice->client_phone ?: ($invoice->company?->phone ?? ''),
                'sale_order_ref' => (string) $invoice->bill_number,
                'currency' => 'SR',
            ],
            'qr_image_data_uri' => $qrImage,
            'items' => $items,
            'summary' => $totals,
            'karat_totals' => [
                'karat_24_weight' => $karatTotals[24],
                'karat_22_weight' => $karatTotals[22],
                'karat_21_weight' => $karatTotals[21],
                'karat_18_weight' => $karatTotals[18],
            ],
            'payments' => [
                'cash_amount' => $cashAmount,
                'card_amount' => $cardAmount,
            ],
            'seller' => [
                'seller_name' => auth()->user()?->name ?? '',
            ],
            'footer' => [
                'footer_ar' => $this->buildFooterLine(
                    $branch?->branch_address,
                    $branch?->branch_phone,
                    'المملكة العربية السعودية'
                ),
                'footer_en' => $this->buildFooterLine(
                    $branch?->branch_address,
                    $branch?->branch_phone,
                    'Kingdom of Saudi Arabia'
                ),
            ],
        ];
    }

    public function calculateTotals(array $items, float $discount = 0.0): array
    {
        $netAfterDiscount = 0.0;
        $vatTotal = 0.0;

        foreach ($items as $item) {
            $netAfterDiscount += (float) ($item['subtotal_excl_vat'] ?? 0);
            $vatTotal += (float) ($item['vat_amount'] ?? 0);
        }

        $netBeforeDiscount = $netAfterDiscount + $discount;
        $grandTotal = $netAfterDiscount + $vatTotal;

        return [
            'net_before_discount' => round($netBeforeDiscount, 2),
            'discount_total' => round($discount, 2),
            'net_after_discount' => round($netAfterDiscount, 2),
            'vat_total' => round($vatTotal, 2),
            'grand_total' => round($grandTotal, 2),
        ];
    }

    private function buildQrImage(string $seller, string $vatNumber, Carbon $issuedAt, float $total, float $vat): string
    {
        if ($seller === '' || $vatNumber === '') {
            return '';
        }

        return GenerateQrCode::fromArray([
            new Seller($seller),
            new TaxNumber($vatNumber),
            new InvoiceDate($issuedAt->format('Y-m-d\TH:i:s')),
            new InvoiceTotalAmount($total),
            new InvoiceTaxAmount($vat),
        ])->render();
    }

    private function resolveLogoPath(?string $logo): string
    {
        $defaultLogo = public_path('assets/img/logo.png');
        if (!$logo) {
            return $defaultLogo;
        }

        $original = trim($logo);
        $original = trim($original, "\"'");
        if (
            !str_starts_with($original, 'http://')
            && !str_starts_with($original, 'https://')
            && file_exists($original)
        ) {
            return $original;
        }

        $normalized = $original;
        $normalized = str_replace('\\', '/', $normalized);
        $normalized = trim($normalized, '/');
        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            $normalized = ltrim(parse_url($normalized, PHP_URL_PATH) ?? '', '/');
        }
        if (
            (preg_match('/^[A-Za-z]:\\//', $normalized) || str_starts_with($normalized, '/'))
            && file_exists($normalized)
        ) {
            return $normalized;
        }

        $basename = basename($normalized);
        $candidates = [
            public_path('uploads/CompanyInfo/' . $normalized),
            public_path('uploads/CompanyInfo/' . $basename),
            public_path($normalized),
            public_path($basename),
            base_path('uploads/CompanyInfo/' . $normalized),
            base_path('uploads/CompanyInfo/' . $basename),
            base_path('uploads/' . $normalized),
            base_path('uploads/' . $basename),
            base_path($normalized),
            base_path($basename),
            public_path('storage/' . $normalized),
            public_path('storage/' . $basename),
            storage_path('app/public/' . $normalized),
            storage_path('app/public/' . $basename),
            public_path('uploads/' . $normalized),
            public_path('uploads/' . $basename),
        ];

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return $defaultLogo;
    }

    private function buildFooterLine(?string $address, ?string $phone, string $prefix): string
    {
        $parts = array_filter([
            $prefix,
            $address,
            $phone ? 'Tel: ' . $phone : null,
        ]);

        return implode(' - ', $parts);
    }
}
