<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->dropForeign(['invoice_id']);
            $table->unsignedBigInteger('registration_id')->nullable()->change();
            $table->unsignedBigInteger('invoice_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            // nullable revert गर्न गाह्रो, तर आवश्यक परेमा गर्न सकिन्छ
        });
    }
};