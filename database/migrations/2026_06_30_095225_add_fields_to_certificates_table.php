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
    Schema::table('certificates', function (Blueprint $table) {
        $table->string('operator_name')->nullable()->after('registration_id');
        $table->string('address')->nullable()->after('operator_name');
        $table->string('contact')->nullable()->after('address');
        $table->string('pan')->nullable()->after('contact');
    });
}

public function down()
{
    Schema::table('certificates', function (Blueprint $table) {
        $table->dropColumn(['operator_name', 'address', 'contact', 'pan']);
    });
}
};
