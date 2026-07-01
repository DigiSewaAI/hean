<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'invoice_type')) {
                $table->enum('invoice_type', [
                    'new_registration',
                    'renewal',
                    'membership_fee',
                    'inspection_fee',
                    'certificate_fee',
                    'penalty',
                    'other'
                ])->default('other')->after('invoice_number');
            }
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'invoice_type')) {
                $table->dropColumn('invoice_type');
            }
        });
    }
};