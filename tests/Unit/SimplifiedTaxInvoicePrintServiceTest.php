<?php

namespace Tests\Unit;

use App\Services\SimplifiedTaxInvoicePrintService;
use PHPUnit\Framework\TestCase;

class SimplifiedTaxInvoicePrintServiceTest extends TestCase
{
    public function test_calculate_totals(): void
    {
        $service = new SimplifiedTaxInvoicePrintService();

        $items = [
            ['subtotal_excl_vat' => 100.0, 'vat_amount' => 15.0],
            ['subtotal_excl_vat' => 200.0, 'vat_amount' => 30.0],
        ];

        $totals = $service->calculateTotals($items, 10.0);

        $this->assertEquals(310.0, $totals['net_before_discount']);
        $this->assertEquals(10.0, $totals['discount_total']);
        $this->assertEquals(300.0, $totals['net_after_discount']);
        $this->assertEquals(45.0, $totals['vat_total']);
        $this->assertEquals(345.0, $totals['grand_total']);
    }
}
