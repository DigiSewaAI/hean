<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'status')) {
                $table->enum('status', ['pending', 'verified', 'rejected', 'refunded'])
                    ->default('pending')->after('screenshot_path');
            }
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};