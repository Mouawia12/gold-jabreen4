<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SimplifiedTaxInvoicePrintService;
use Barryvdh\Snappy\Facades\SnappyPdf;

class SimplifiedTaxInvoicePrintController extends Controller
{
    public function __construct(private SimplifiedTaxInvoicePrintService $service)
    {
    }

    public function print(int $invoice)
    {
        $data = $this->service->build($invoice);

        $html = view('prints.simplified_tax_invoice', $data)->render();
        $fileName = 'invoice-' . $data['invoice']['invoice_no'] . '.pdf';

        $pdfBinary = $this->renderPdf($html);

        return response($pdfBinary, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }

    private function renderPdf(string $html): string
    {
        return SnappyPdf::loadHTML($html)
            ->setPaper('a4')
            ->setOption('encoding', 'utf-8')
            ->setOption('enable-local-file-access', true)
            ->setOption('page-size', 'A4')
            ->setOption('margin-top', 8)
            ->setOption('margin-right', 8)
            ->setOption('margin-bottom', 8)
            ->setOption('margin-left', 8)
            ->setOption('dpi', 96)
            ->setOption('zoom', 1)
            ->setOption('disable-smart-shrinking', true)
            ->output();
    }
}
