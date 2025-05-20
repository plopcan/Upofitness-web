<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Invoice;
use App\Models\Order;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_can_be_created()
    {
        $order = Order::factory()->create();
        $invoice = Invoice::create([
            'issue_date' => now(),
            'tax_percentage' => 21,
            'total_amount' => 100,
            'orders_id' => $order->id,
        ]);
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'orders_id' => $order->id,
        ]);
    }

    public function test_invoice_belongs_to_order()
    {
        $order = Order::factory()->create();
        $invoice = Invoice::factory()->create([
            'orders_id' => $order->id,
        ]);
        $this->assertInstanceOf(Order::class, $invoice->order);
        $this->assertEquals($order->id, $invoice->order->id);
    }

    public function test_invoice_can_be_updated()
    {
        $invoice = Invoice::factory()->create();
        $invoice->tax_percentage = 10;
        $invoice->save();
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'tax_percentage' => 10,
        ]);
    }

    public function test_invoice_can_be_deleted()
    {
        $invoice = Invoice::factory()->create();
        $invoice->delete();
        $this->assertDatabaseMissing('invoices', [
            'id' => $invoice->id,
        ]);
    }
}
