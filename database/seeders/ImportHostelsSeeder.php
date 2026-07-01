<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\HostelsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportHostelsSeeder extends Seeder
{
    public function run()
    {
        $file = public_path('hostels.csv');

        if (!file_exists($file)) {
            $this->command->error("CSV file not found at: $file");
            return;
        }

        Excel::import(new HostelsImport, $file);

        $this->command->info('✅ Hostels imported successfully from CSV!');
    }
}