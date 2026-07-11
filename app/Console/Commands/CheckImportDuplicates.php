<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registration;

class CheckImportDuplicates extends Command
{
    protected $signature = 'import:check-duplicates {file}';
    protected $description = 'Check CSV rows against existing DB records to see why they were skipped.';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $this->info("📂 Reading file: $file");

        // Read CSV
        $content = file_get_contents($file);
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');
        $lines = explode("\n", $content);

        if (count($lines) < 2) {
            $this->error("File is empty or invalid.");
            return 1;
        }

        // Skip header
        $header = str_getcsv($lines[0]);
        $this->line("Headers: " . implode(', ', $header));

        $totalDuplicates = 0;
        $rowNumber = 1;

        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) continue;

            $row = str_getcsv($line);
            $rowNumber++;

            $oldRegNumber = trim($row[0] ?? '');
            $contact = trim($row[5] ?? '');

            if (empty($contact) && empty($oldRegNumber)) {
                continue;
            }

            // Check if this record exists in DB
            $existing = Registration::where('contact', $contact)
                ->orWhere('old_registration_number', $oldRegNumber)
                ->first();

            if ($existing) {
                $totalDuplicates++;
                $this->line("----------------------------------------");
                $this->line("❌ ROW $rowNumber (Excel Row): Skipped");
                $this->line("   ➜ CSV Contact : $contact");
                $this->line("   ➜ CSV Old Reg #: $oldRegNumber");
                $this->line("");
                $this->line("   ➜ 🏠 Existing Hostel in DB:");
                $this->line("       - ID: {$existing->id}");
                $this->line("       - Name: {$existing->hostel_name}");
                $this->line("       - HEAN No: {$existing->registration_number}");
                $this->line("       - Contact: {$existing->contact}");
                $this->line("       - Old Reg #: {$existing->old_registration_number}");
                $this->line("----------------------------------------");
            }
        }

        $this->info("\n✅ Total Duplicates Found: $totalDuplicates");
        return 0;
    }
}