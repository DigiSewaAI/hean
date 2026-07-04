<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // ----- HOSTELS TABLE -----
        if (!Schema::hasColumn('hostels', 'registration_number')) {
            Schema::table('hostels', function (Blueprint $table) {
                $table->string('registration_number')->nullable()->unique()->after('id');
            });
        }
        if (!Schema::hasColumn('hostels', 'block_name')) {
            Schema::table('hostels', function (Blueprint $table) {
                $table->string('block_name')->nullable()->after('name_english');
            });
        }

        // विद्यमान होस्टलहरूलाई दर्ता नम्बर प्रदान गर्ने (तर NULL भएकोलाई मात्र)
        $hostels = DB::table('hostels')
            ->whereNull('registration_number')
            ->orderBy('id')
            ->get();

        foreach ($hostels as $hostel) {
            $year = date('Y', strtotime($hostel->created_at));
            $sequence = str_pad($hostel->id, 6, '0', STR_PAD_LEFT);
            DB::table('hostels')
                ->where('id', $hostel->id)
                ->update(['registration_number' => "HEAN-{$year}-{$sequence}"]);
        }

        // ----- REGISTRATIONS TABLE -----
        if (!Schema::hasColumn('registrations', 'registration_number')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('registration_number')->nullable()->after('id');
            });
        }
        if (!Schema::hasColumn('registrations', 'block_name')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('block_name')->nullable()->after('hostel_name_english');
            });
        }

        // विद्यमान registrations मा hostel बाट registration_number प्रतिलिपि गर्ने (तर NULL भएकोलाई मात्र)
        $registrations = DB::table('registrations')
            ->whereNotNull('hostel_id')
            ->whereNull('registration_number')
            ->get();

        foreach ($registrations as $reg) {
            $hostel = DB::table('hostels')->where('id', $reg->hostel_id)->first();
            if ($hostel && $hostel->registration_number) {
                DB::table('registrations')
                    ->where('id', $reg->id)
                    ->update(['registration_number' => $hostel->registration_number]);
            }
        }

        // ⚠️ PAN, EMAIL, CONTACT का UNIQUE INDEX हटाउने आवश्यक छैन – तपाईंको डाटाबेसमा ती unique छैनन् (SHOW INDEX देखाउँछ)।
        // यदि तपाईंले ती सामान्य INDEX हटाउनै चाहनुहुन्छ भने मात्र तलका पङ्क्तिहरू खोल्नुहोस्:
        // Schema::table('registrations', function (Blueprint $table) {
        //     $table->dropIndex('registrations_pan_index');
        //     $table->dropIndex('registrations_email_index');
        //     $table->dropIndex('registrations_contact_index');
        // });
    }

    public function down()
    {
        // डाउनमा पनि column अवस्थित भए मात्र हटाउने
        if (Schema::hasColumn('hostels', 'registration_number')) {
            Schema::table('hostels', function (Blueprint $table) {
                $table->dropColumn('registration_number');
            });
        }
        if (Schema::hasColumn('hostels', 'block_name')) {
            Schema::table('hostels', function (Blueprint $table) {
                $table->dropColumn('block_name');
            });
        }
        if (Schema::hasColumn('registrations', 'registration_number')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn('registration_number');
            });
        }
        if (Schema::hasColumn('registrations', 'block_name')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn('block_name');
            });
        }
    }
};