<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class UpdatePanFromCsv extends Command
{
    protected $signature = 'update:pan';
    protected $description = 'Update PAN numbers from CSV with improved matching';

    public function handle()
    {
        $file = base_path('Record File Of Hostel Entrepreneur (Modified).csv');

        if (!file_exists($file)) {
            $this->error("❌ File not found: $file");
            return 1;
        }

        $this->info("📂 Reading: " . basename($file));

        $lines = file($file);
        $headers = str_getcsv(array_shift($lines));

        // Indexes (adjust if needed)
        $nameIdx = array_search('HOSTEL\'S NAME', $headers);
        $contactIdx = array_search('PHONE NO', $headers);
        $panIdx = array_search('PAN Number', $headers);
        $oldRegIdx = array_search('OLD REG NO', $headers); // यदि छ भने

        $updated = 0;
        $skipped = 0;
        $notFound = 0;

        DB::beginTransaction();
        try {
            foreach ($lines as $line) {
                $row = str_getcsv(trim($line));
                if (count($row) < 3) continue;

                $pan = trim($row[$panIdx] ?? '');
                if (empty($pan)) { $skipped++; continue; }

                $contact = trim($row[$contactIdx] ?? '');
                $name = trim($row[$nameIdx] ?? '');
                $oldReg = trim($row[$oldRegIdx] ?? '');

                // Normalize contact (remove spaces, +977, leading 0)
                $normalizedContact = preg_replace('/[^0-9]/', '', $contact);
                if (strlen($normalizedContact) == 10) {
                    $normalizedContact = '97' . $normalizedContact; // fallback
                }

                // Find registration
                $reg = Registration::where('contact', $contact)
                    ->orWhere('contact', $normalizedContact)
                    ->orWhere('old_registration_number', $oldReg)
                    ->orWhere('hostel_name', $name)
                    ->orWhere('hostel_name_english', $name)
                    ->first();

                if ($reg) {
                    $reg->pan = $pan;
                    $reg->save();
                    $updated++;
                    $this->line("✅ Updated: {$reg->hostel_name} -> $pan");
                } else {
                    $notFound++;
                    $this->warn("⚠️ Not found: $name (contact: $contact)");
                }
            }
            DB::commit();

            $this->info("\n✅ Total PAN updated: $updated");
            $this->info("⏭️ Skipped: $skipped");
            $this->info("❌ Not found: $notFound");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}