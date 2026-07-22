<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    $invoices = DB::table('invoices')->get();
    foreach ($invoices as $invoice) {
        $description = $invoice->invoice_type ?? 'Fee';
        DB::table('invoice_items')->insert([
            'invoice_id' => $invoice->id,
            'description' => $description,
            'quantity' => 1,
            'unit_price' => $invoice->amount,
            'amount' => $invoice->amount,
            'sort_order' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('invoices')->where('id', $invoice->id)->update([
            'subtotal' => $invoice->amount,
            'discount' => 0,
            'tax' => 0,
        ]);
    }
}

public function down()
{
    DB::table('invoice_items')->truncate();
    DB::table('invoices')->update([
        'subtotal' => 0,
        'discount' => 0,
        'tax' => 0,
    ]);
}
};
