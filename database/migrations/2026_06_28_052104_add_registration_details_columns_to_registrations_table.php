<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('hostel_type')->nullable()->after('hostel_name');
            $table->integer('capacity')->nullable()->after('hostel_type');
            $table->integer('established_year')->nullable()->after('capacity');
            $table->string('email')->nullable()->after('contact');
            $table->string('website')->nullable()->after('email');
            $table->string('province')->nullable()->after('district');
            $table->string('landmark')->nullable()->after('street');
        });
    }

    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['hostel_type', 'capacity', 'established_year', 'email', 'website', 'province', 'landmark']);
        });
    }
};