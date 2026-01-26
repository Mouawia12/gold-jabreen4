<?php

namespace Tests\Feature;

use App\Services\SimplifiedTaxInvoicePrintService;
use Tests\TestCase;

class SimplifiedTaxInvoicePrintTest extends TestCase
{
    public function test_print_route_returns_pdf(): void
    {
        if (!class_exists(\Barryvdh\Snappy\Facades\SnappyPdf::class)) {
            $this->markTestSkipped('SnappyPdf is not installed; run composer install to enable PDF rendering.');
        }

        $this->withoutMiddleware();

        $this->mock(SimplifiedTaxInvoicePrintService::class, function ($mock) {
            $mock->shouldReceive('build')
                ->once()
                ->andReturn($this->fakeInvoiceData());
        });

        $response = $this->get('/admin/sales/simplified-tax/123/print');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    private function fakeInvoiceData(): array
    {
        return [
            'company' => [
                'company_ar' => 'شركة الاختبار',
                'company_en' => 'Test Company',
                'tax_number' => '1234567890',
                'commercial_registry' => 'CR123',
                'mineral_license' => '',
                'address_ar' => 'الرياض',
                'address_en' => 'Riyadh',
                'phone' => '0500000000',
                'logo_path' => public_path('assets/img/logo.png'),
            ],
            'branch' => [
                'branch_ar' => 'فرع الرياض',
                'branch_en' => 'Riyadh Branch',
                'branch_address_ar' => 'حي النسيم',
                'branch_address_en' => 'Al Naseem',
                'branch_phone' => '0110000000',
            ],
            'invoice' => [
                'invoice_no' => 'INV/2026/00080',
                'date' => '20/01/2026',
                'time' => '23:02:01',
                'type' => 'شبكة',
                'customer_name' => 'عميل نقدي',
                'customer_phone' => '0550000000',
                'sale_order_ref' => 'NAS/S00130',
                'currency' => 'SR',
            ],
            'qr_image_data_uri' => 'data:image/png;base64,AA==',
            'items' => [
                [
                    'line_no' => 1,
                    'description' => 'اسواره اصفر 18',
                    'karat' => '18',
                    'karat_value' => 18,
                    'weight' => 3.2,
                    'metal_extra' => 0,
                    'gram_price' => 489.13,
                    'qty' => 1,
                    'subtotal_excl_vat' => 1565.22,
                    'vat_amount' => 234.78,
                    'vat_rate' => 15,
                    'total_incl_vat' => 1800,
                ],
            ],
            'summary' => [
                'net_before_discount' => 1565.22,
                'discount_total' => 0,
                'net_after_discount' => 1565.22,
                'vat_total' => 234.78,
                'grand_total' => 1800.00,
            ],
            'karat_totals' => [
                'karat_24_weight' => 0,
                'karat_22_weight' => 0,
                'karat_21_weight' => 0,
                'karat_18_weight' => 3.2,
            ],
            'payments' => [
                'cash_amount' => 0,
                'card_amount' => 1800,
            ],
            'seller' => [
                'seller_name' => 'أحمد',
            ],
            'footer' => [
                'footer_ar' => 'المملكة العربية السعودية - الرياض - تليفون 0110000000',
                'footer_en' => 'Kingdom of Saudi Arabia - Riyadh - Tel: 0110000000',
            ],
        ];
    }
}
