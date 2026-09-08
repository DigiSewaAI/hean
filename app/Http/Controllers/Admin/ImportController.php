<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    public function prepare(Request $request)
    {
        return back()->with('info', 'Import preparation is under development.');
    }

    /**
 * Execute import – from CSV/Excel
 * ✅ Handles empty fields with defaults
 * ✅ Auto-generates HEAN-YYYY-XXXXXX
 * ✅ Ignores old S.N. for duplicate check (only contact matters)
 * ✅ Supports Registration Date from column 15 (AD format)
 */
public function store(Request $request)
{
    // =============================================
    // 1. FILE VALIDATION
    // =============================================
    $request->validate([
        'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB
    ]);

    // =============================================
    // 2. STORE FILE TEMPORARILY
    // =============================================
    $file = $request->file('file');
    $path = $file->store('imports', 'public'); // storage/app/public/imports/...
    $fullPath = Storage::disk('public')->path($path);

    // =============================================
    // 3. READ FILE (CSV or Excel)
    // =============================================
    $extension = $file->getClientOriginalExtension();
    if ($extension === 'csv') {
        $rows = [];
        if (($handle = fopen($fullPath, 'r')) !== false) {
            $headers = fgetcsv($handle); // Skip header row
            while (($data = fgetcsv($handle)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
    } else {
        $spreadsheet = IOFactory::load($fullPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        array_shift($rows); // Remove header row
    }

    // =============================================
    // 4. IMPORT LOOP
    // =============================================
    $imported = 0;
    $errors = [];

    DB::beginTransaction();
    try {
        foreach ($rows as $index => $row) {
            // ================================================
            // 1. EXTRACT DATA WITH DEFAULTS
            // ================================================
            $oldRegNumber = trim($row[0] ?? ''); // S.N. (पुरानो HEAN नम्बर) – अब ignore
            $hostelNameEnglish = trim($row[1] ?? '');
            $hostelNameNepali = trim($row[2] ?? '');
            $address = trim($row[3] ?? '');
            $ownerName = trim($row[4] ?? '');
            $contact = trim($row[5] ?? '');
            $pan = trim($row[6] ?? '');
            $ward = trim($row[7] ?? '');
            $capacity = (int) ($row[13] ?? 0);
            $remarks = trim($row[14] ?? '');
            $registrationDate = trim($row[15] ?? ''); // ✅ नयाँ: Registration Date (AD)

            // ================================================
            // 2. FALLBACK LOGIC FOR EMPTY FIELDS
            // ================================================
            // Hostel Name
            if (empty($hostelNameNepali) && !empty($hostelNameEnglish)) {
                $hostelNameNepali = $hostelNameEnglish;
            } elseif (empty($hostelNameNepali) && empty($hostelNameEnglish)) {
                $hostelNameNepali = 'Unknown Hostel';
                $hostelNameEnglish = 'Unknown Hostel';
            }

            // Owner Name
            if (empty($ownerName)) {
                $ownerName = 'Unknown';
            }

            // Contact
            if (empty($contact)) {
                $contact = 'N/A';
            }

            // Ward
            if (empty($ward)) {
                $ward = '0';
            }

            // Old Registration Number – अब आवश्यक नभए पनि राख्छौं (तर duplicate check मा ignore)
            if (empty($oldRegNumber)) {
                $oldRegNumber = 'N/A';
            }

            // Capacity
            if ($capacity <= 0) {
                $capacity = 0;
            }

            // ================================================
            // 3. REGISTRATION DATE (AD) – यदि छ भने प्रयोग गर्ने, नभए now()
            // ================================================
            if (!empty($registrationDate)) {
                // मानौं `$registrationDate` "2026-05-09" (Y-m-d) format मा छ
                $submitted_at = date('Y-m-d', strtotime($registrationDate));
                $valid_from = $submitted_at;
                $valid_until = date('Y-m-d', strtotime($submitted_at . ' +1 year'));
            } else {
                $submitted_at = now();
                $valid_from = now();
                $valid_until = now()->addYear();
            }

            // ================================================
            // 4. DETECT HOSTEL TYPE FROM NAME
            // ================================================
            $type = 'co-ed';
            $nameLower = strtolower($hostelNameNepali . ' ' . $hostelNameEnglish);
            if (strpos($nameLower, 'girls') !== false || strpos($nameLower, 'girl') !== false) {
                $type = 'girls';
            } elseif (strpos($nameLower, 'boys') !== false || strpos($nameLower, 'boy') !== false) {
                $type = 'boys';
            }

            // ================================================
            // 5. DEFAULT DISTRICT & MUNICIPALITY
            // ================================================
            $district = 'Kathmandu';
            $municipality = 'Kathmandu Metropolitan City';

            // ================================================
            // 6. SKIP IF NO VALID DATA
            // ================================================
            if (empty($hostelNameNepali) && empty($hostelNameEnglish)) {
                $errors[] = "Row " . ($index + 2) . ": Hostel name is empty. Skipped.";
                continue;
            }

            // ================================================
            // 7. CHECK DUPLICATE – Contact मा मात्र (S.N. ignore)
            // ================================================
            $existing = Registration::where('contact', $contact)->first();

            if ($existing) {
                $errors[] = "Row " . ($index + 2) . ": Duplicate found (Contact: {$contact}). Skipped.";
                continue;
            }

            // ================================================
            // 8. CREATE REGISTRATION (registration_number event बाट आउँछ)
            // ================================================
            $registration = Registration::create([
                'hostel_name' => $hostelNameNepali,
                'hostel_name_english' => $hostelNameEnglish,
                'operator_name' => $ownerName,
                'contact' => $contact,
                'pan' => $pan ?: null,
                'ward' => $ward,
                'capacity' => $capacity,
                'hostel_type' => $type,
                'street' => $address ?: null,
                'district' => $district,
                'municipality' => $municipality,
                'description' => $remarks ?: null,
                'old_registration_number' => $oldRegNumber, // राखियो तर अब duplicate check मा छैन
                'status' => 'active',
                'source' => 'import',
                'submitted_at' => $submitted_at,
                'approved_at' => $submitted_at,
                'valid_from' => $valid_from,
                'valid_until' => $valid_until,
            ]);

            // ================================================
            // 9. CREATE HOSTEL (event ले registration_number generate गर्छ)
            // ================================================
            $hostel = Hostel::create([
                'name_nepali' => $hostelNameNepali,
                'name_english' => $hostelNameEnglish,
                'operator_name' => $ownerName,
                'contact' => $contact,
                'ward' => $ward,
                'capacity' => $capacity,
                'type' => $type,
                'street' => $address ?: null,
                'district' => $district,
                'municipality' => $municipality,
                'old_registration_number' => $oldRegNumber,
                'description' => $remarks ?: null,
                'approved' => true,
                'visible' => true,
                'featured' => false,
                'owner_id' => null,
            ]);

            // ================================================
            // 10. REFRESH & COPY registration_number
            // ================================================
            $hostel->refresh();
            $registration->hostel_id = $hostel->id;
            if (empty($registration->registration_number)) {
                $registration->registration_number = $hostel->registration_number;
            }
            $registration->save();

            // ================================================
            // 11. CREATE INVOICE, PAYMENT, RECEIPT
            // ================================================
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::max('id') + 1, 6, '0', STR_PAD_LEFT);
            $invoice = Invoice::create([
                'registration_id' => $registration->id,
                'invoice_number' => $invoiceNumber,
                'amount' => 0,
                'issued_date' => $submitted_at,
                'due_date' => $submitted_at,
                'status' => 'paid',
                'invoice_type' => 'membership_fee',
                'pdf_path' => null,
            ]);

            $payment = Payment::create([
                'registration_id' => $registration->id,
                'invoice_id' => $invoice->id,
                'method' => 'cash',
                'amount' => 0,
                'payment_date' => $submitted_at,
                'status' => 'verified',
                'verified_at' => $submitted_at,
                'verified_by' => auth()->id(),
                'remarks' => 'Imported from Excel',
            ]);

            $receiptNumber = 'RCP-' . date('Y') . '-' . str_pad(Receipt::max('id') + 1, 6, '0', STR_PAD_LEFT);
            Receipt::create([
                'payment_id' => $payment->id,
                'receipt_number' => $receiptNumber,
                'amount' => 0,
                'issued_date' => $submitted_at,
                'pdf_path' => null,
                'remarks' => 'Imported from Excel',
            ]);

            $imported++;
        }

        DB::commit();

        // =============================================
        // 12. DELETE TEMPORARY FILE & REDIRECT
        // =============================================
        Storage::disk('public')->delete($path);

        return redirect()->route('admin.hostels.index')
            ->with('success', "✅ Successfully imported {$imported} hostels. Errors: " . count($errors))
            ->with('errors', $errors);

    } catch (\Exception $e) {
        DB::rollBack();
        Storage::disk('public')->delete($path);
        \Log::error('Bulk import failed: ' . $e->getMessage());
        return back()->with('error', '❌ Import failed: ' . $e->getMessage());
    }
}
}