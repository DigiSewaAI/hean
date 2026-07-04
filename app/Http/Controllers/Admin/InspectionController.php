<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class InspectionController extends Controller
{
    /**
     * सबै निरीक्षणको सूची (admin panel को inspection list)
     */
    public function index()
    {
        $inspections = Inspection::with(['registration', 'inspector'])
            ->latest()
            ->paginate(15);

        return view('admin.inspections.index', compact('inspections'));
    }

    /**
     * निरीक्षण फारम देखाउने (चेकलिस्ट)
     */
    public function create(Registration $registration)
    {
        return view('admin.inspections.create', compact('registration'));
    }

    /**
     * निरीक्षण डाटा सेभ गर्ने
     * ✅ FIXED: Photos now saved using $inspection->photos = $photoPaths; $inspection->save();
     */
    public function store(Request $request)
    {
        // १. भ्यालिडेसन
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'checklist' => 'nullable|array',
            'checklist.*' => 'in:yes,no',
            'remarks' => 'nullable|array',
            'remarks.*' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'signature' => 'required|string|max:255',
        ]);

        $registration = Registration::findOrFail($request->registration_id);

        DB::beginTransaction();
        try {
            // २. Checklist र remarks लाई JSON मा मर्ज गर्ने
            $checklistData = [
                'items'   => $request->checklist ?? [],
                'remarks' => $request->remarks ?? [],
            ];

            // ३. Inspection record सिर्जना
            $inspection = Inspection::create([
                'registration_id' => $registration->id,
                'inspector_id'    => auth()->user()->id,
                'completed_date'  => now(),
                'remarks'         => $request->signature,
                'status'          => 'completed',
                'checklist'       => json_encode($checklistData),
            ]);

// फोटो अपलोड – अब 'public/' prefix नराखी store
if ($request->hasFile('photos')) {
    $photoPaths = [];
    foreach ($request->file('photos') as $photo) {
        // ✅ 'inspections' मा store गर (बिना 'public/')
        $path = $photo->store('inspections/' . $inspection->id, 'public');
        $photoPaths[] = $path;  // path: 'inspections/4/filename.jpg'
    }
    $inspection->photos = $photoPaths;
    $inspection->save();
}

            // ५. Registration status approve गर्ने
            $registration->update([
                'status'      => 'approved',
                'approved_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.registrations.show', $registration)
                ->with('success', '✅ निरीक्षण पूरा भयो र आवेदन स्वीकृत गरियो।');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Inspection store failed: ' . $e->getMessage(), [
                'registration_id' => $request->registration_id,
                'user'            => auth()->user()->id ?? null,
            ]);

            return back()->withErrors(['general' => 'निरीक्षण सेभ गर्दा त्रुटि भयो: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * ✅ निरीक्षणको लागि योग्य दर्ताहरूको सूची (New Inspection button बाट)
     * ✅ FIXED: अब active र approved status पनि समावेश गरियो।
     * ✅ पहिले नै scheduled/completed भएका registrations हटाइयो।
     */
    public function select()
    {
        $registrations = Registration::whereIn('status', ['pending', 'approved', 'active', 'inspection'])
            ->whereDoesntHave('inspections', function($q) {
                $q->whereIn('status', ['scheduled', 'completed']);
            })
            ->latest()
            ->get();

        return view('admin.inspections.select', compact('registrations'));
    }

    /**
     * View a completed inspection report.
     */
    public function view(Inspection $inspection)
    {
        $inspection->load(['registration', 'inspector']);
        
        // ✅ Define checklist criteria labels (from language file or hardcoded)
        $criteriaLabels = [
            1 => __('messages.inspection_checklist_1'),
            2 => __('messages.inspection_checklist_2'),
            3 => __('messages.inspection_checklist_3'),
            4 => __('messages.inspection_checklist_4'),
            5 => __('messages.inspection_checklist_5'),
            6 => __('messages.inspection_checklist_6'),
            7 => __('messages.inspection_checklist_7'),
            8 => __('messages.inspection_checklist_8'),
            9 => __('messages.inspection_checklist_9'),
            10 => __('messages.inspection_checklist_10'),
            11 => __('messages.inspection_checklist_11'),
        ];
        
        // ✅ Decode checklist JSON to array
        $checklist = [];
        $checklistRemarks = [];
        if ($inspection->checklist) {
            $decoded = json_decode($inspection->checklist, true);
            if (is_array($decoded)) {
                // Get items
                if (isset($decoded['items']) && is_array($decoded['items'])) {
                    $checklist = $decoded['items'];
                } else {
                    $checklist = $decoded;
                }
                // Get remarks
                if (isset($decoded['remarks']) && is_array($decoded['remarks'])) {
                    $checklistRemarks = $decoded['remarks'];
                }
            }
        }
        
        return view('admin.inspections.view', compact('inspection', 'checklist', 'checklistRemarks', 'criteriaLabels'));
    }
}