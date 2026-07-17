<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // MySQL मा ENUM बाट VARCHAR मा बदल्न
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_type', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // पुरानो ENUM मा फर्काउनुहोस् (यदि आवश्यक भए)
            $table->string('invoice_type', 50)->change();
        });
    }
};