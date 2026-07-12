<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        // 1. Foreign Key Drop गर्नुहोस्
        $table->dropForeign('payments_invoice_id_foreign');
        // 2. Column लाई NOT NULL बनाउनुहोस्
        $table->bigInteger('invoice_id')->unsigned()->nullable(false)->change();
        // 3. Foreign Key फेरि Add गर्नुहोस् (अब DELETE SET NULL हटाउने)
        $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropForeign('payments_invoice_id_foreign');
        $table->bigInteger('invoice_id')->unsigned()->nullable()->change();
        $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
    });
}
};