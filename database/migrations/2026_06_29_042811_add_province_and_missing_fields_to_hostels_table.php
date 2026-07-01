<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hostels', function (Blueprint $table) {
            // यी कलमहरू पहिले नै छन् भने add गर्दैन
            if (!Schema::hasColumn('hostels', 'province')) {
                $table->string('province')->nullable()->after('district');
            }
            if (!Schema::hasColumn('hostels', 'established_year')) {
                $table->integer('established_year')->nullable()->after('rooms');
            }
            if (!Schema::hasColumn('hostels', 'email')) {
                $table->string('email')->nullable()->after('contact');
            }
            if (!Schema::hasColumn('hostels', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('hostels', 'landmark')) {
                $table->string('landmark')->nullable()->after('street');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hostels', function (Blueprint $table) {
            $table->dropColumn(['province', 'established_year', 'email', 'website', 'landmark']);
        });
    }
};