<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    // यो फङ्क्सन पछि पूरा गरिनेछ – अहिले केवल प्लेसहोल्डर
    public function prepare(Request $request)
    {
        // ImportPreparationService::prepare($request->file('file'));
        return back()->with('info', 'Import preparation is under development.');
    }
    /**
 * Execute import – from CSV (extracted)
 */
public function store(Request $request)
{
    $filePath = session('import_file');
    if (!$filePath || !Storage::disk('public')->exists($filePath)) {
        return redirect()->route('admin.import.index')
            ->with('error', 'Import file not found. Please upload again.');
    }

    $fullPath = Storage::disk('public')->path($filePath);
    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

    // If it's CSV, use simple fgetcsv
    if ($extension === 'csv') {
        $rows = [];
        if (($handle = fopen($fullPath, 'r')) !== false) {
            $headers = fgetcsv($handle); // Skip headers
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
    } else {
        // Excel file - use PhpSpreadsheet
        $spreadsheet = IOFactory::load($fullPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        array_shift($rows); // Remove headers
    }

    $imported = 0;
    $errors = [];

    DB::beginTransaction();
    try {
        foreach ($rows as $index => $row) {
            // CSV columns: 0:HostelName, 1:OwnerName, 2:Contact, 3:PAN, 4:Ward, 5:Capacity, 6:Province, 7:District, 8:Municipality, 9:Type
            $hostelName = trim($row[0] ?? '');
            $ownerName = trim($row[1] ?? '');
            $contact = trim($row[2] ?? '');
            $pan = trim($row[3] ?? '');
            $ward = trim($row[4] ?? '1');
            $capacity = (int) ($row[5] ?? 0);
            $province = trim($row[6] ?? 'Bagmati');
            $district = trim($row[7] ?? 'Kathmandu');
            $municipality = trim($row[8] ?? 'Kathmandu Metropolitan City');
            $type = trim(strtolower($row[9] ?? 'co-ed'));

            if (empty($hostelName)) {
                $errors[] = "Row " . ($index + 2) . ": Hostel name is empty. Skipped.";
                continue;
            }

            // Check duplicate by PAN or Contact
            $existing = Registration::where('pan', $pan)
                ->orWhere('contact', $contact)
                ->where('status', '!=', 'rejected')
                ->first();

            if ($existing) {
                $errors[] = "Row " . ($index + 2) . ": Duplicate found (PAN/Contact). Skipped.";
                continue;
            }

            // Create Registration
            $registration = Registration::create([
                'hostel_name' => $hostelName,
                'hostel_name_english' => null,
                'hostel_type' => $type,
                'capacity' => $capacity,
                'rooms' => ceil($capacity / 3), // Approximate rooms
                'established_year' => date('Y') - 5,
                'contact' => $contact,
                'email' => null,
                'province' => $province,
                'district' => $district,
                'municipality' => $municipality,
                'ward' => $ward,
                'street' => null,
                'landmark' => null,
                'operator_name' => $ownerName,
                'pan' => $pan,
                'description' => 'Imported from Excel',
                'status' => 'active',
                'source' => 'import',
                'submitted_at' => now(),
                'approved_at' => now(),
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
                'registration_number' => 'REG-' . date('Y') . '-' . str_pad(Registration::max('id') + 1, 5, '0', STR_PAD_LEFT),
            ]);

            // Create Hostel
            $hostel = Hostel::create([
                'name_nepali' => $hostelName,
                'name_english' => null,
                'operator_name' => $ownerName,
                'contact' => $contact,
                'description' => 'Imported from Excel',
                'province' => $province,
                'district' => $district,
                'municipality' => $municipality,
                'ward' => $ward,
                'street' => null,
                'landmark' => null,
                'type' => $type,
                'capacity' => $capacity,
                'rooms' => ceil($capacity / 3),
                'established_year' => date('Y') - 5,
                'email' => null,
                'approved' => true,
                'visible' => true,
                'featured' => false,
                'owner_id' => null,
            ]);

            $registration->hostel_id = $hostel->id;
            $registration->save();

            // Create Invoice
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT);
            $invoice = Invoice::create([
                'registration_id' => $registration->id,
                'invoice_number' => $invoiceNumber,
                'amount' => 0,
                'issued_date' => now(),
                'due_date' => now(),
                'status' => 'paid',
                'invoice_type' => 'membership_fee',
                'pdf_path' => null,
            ]);

            // Create Payment
            $payment = Payment::create([
                'registration_id' => $registration->id,
                'invoice_id' => $invoice->id,
                'method' => 'cash',
                'amount' => 0,
                'payment_date' => now(),
                'status' => 'verified',
                'verified_at' => now(),
                'verified_by' => auth()->id(),
                'remarks' => 'Imported from Excel',
            ]);

            // Create Receipt
            $receiptNumber = 'RCP-' . date('Y') . '-' . str_pad(Receipt::max('id') + 1, 6, '0', STR_PAD_LEFT);
            Receipt::create([
                'payment_id' => $payment->id,
                'receipt_number' => $receiptNumber,
                'amount' => 0,
                'issued_date' => now(),
                'pdf_path' => null,
                'remarks' => 'Imported from Excel',
            ]);

            $imported++;
        }

        DB::commit();
        session()->forget('import_file');

        return redirect()->route('admin.hostels.index')
            ->with('success', "✅ Successfully imported {$imported} hostels. Errors: " . count($errors))
            ->with('errors', $errors);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Bulk import failed: ' . $e->getMessage());
        return back()->with('error', '❌ Import failed: ' . $e->getMessage());
    }
}
}