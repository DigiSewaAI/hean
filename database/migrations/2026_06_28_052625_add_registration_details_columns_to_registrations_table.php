<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Only add columns if they don't already exist
            if (!Schema::hasColumn('registrations', 'hostel_type')) {
                $table->string('hostel_type')->nullable()->after('hostel_name');
            }
            if (!Schema::hasColumn('registrations', 'capacity')) {
                $table->integer('capacity')->nullable()->after('hostel_type');
            }
            if (!Schema::hasColumn('registrations', 'established_year')) {
                $table->integer('established_year')->nullable()->after('capacity');
            }
            if (!Schema::hasColumn('registrations', 'email')) {
                $table->string('email')->nullable()->after('contact');
            }
            if (!Schema::hasColumn('registrations', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('registrations', 'description')) {
                $table->text('description')->nullable()->after('website');
            }
            if (!Schema::hasColumn('registrations', 'province')) {
                $table->string('province')->nullable()->after('district');
            }
            if (!Schema::hasColumn('registrations', 'landmark')) {
                $table->string('landmark')->nullable()->after('street');
            }
        });
    }

    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $columns = ['hostel_type', 'capacity', 'established_year', 'email', 'website', 'description', 'province', 'landmark'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('registrations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};