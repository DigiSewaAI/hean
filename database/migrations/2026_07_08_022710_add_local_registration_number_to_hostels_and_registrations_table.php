<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ----- HOSTELS TABLE -----
        if (!Schema::hasColumn('hostels', 'local_registration_number')) {
            Schema::table('hostels', function (Blueprint $table) {
                $table->string('local_registration_number')->nullable()->after('registration_number');
            });
        }

        // ----- REGISTRATIONS TABLE -----
        if (!Schema::hasColumn('registrations', 'local_registration_number')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('local_registration_number')->nullable()->after('registration_number');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('hostels', 'local_registration_number')) {
            Schema::table('hostels', function (Blueprint $table) {
                $table->dropColumn('local_registration_number');
            });
        }
        if (Schema::hasColumn('registrations', 'local_registration_number')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn('local_registration_number');
            });
        }
    }
};