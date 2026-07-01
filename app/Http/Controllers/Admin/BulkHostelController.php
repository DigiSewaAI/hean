<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hostel;
use Illuminate\Http\Request;

class BulkHostelController extends Controller
{
    public function bulk(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:hostels,id',
            'bulk_action' => 'required|in:approve,reject,feature,unfeature,hide,show,delete',
        ]);

        $ids = $request->ids;
        $action = $request->bulk_action;

        try {
            switch ($action) {
                case 'approve':
                    Hostel::whereIn('id', $ids)->update(['approved' => true]);
                    $message = 'चयन गरिएका होस्टेलहरू स्वीकृत गरियो।';
                    break;
                case 'reject':
                    Hostel::whereIn('id', $ids)->update(['approved' => false]);
                    $message = 'चयन गरिएका होस्टेलहरू अस्वीकृत गरियो।';
                    break;
                case 'feature':
                    Hostel::whereIn('id', $ids)->update(['featured' => true]);
                    $message = 'चयन गरिएका होस्टेलहरू फिचर्ड गरियो।';
                    break;
                case 'unfeature':
                    Hostel::whereIn('id', $ids)->update(['featured' => false]);
                    $message = 'चयन गरिएका होस्टेलहरूको फिचर्ड हटाइयो।';
                    break;
                case 'hide':
                    Hostel::whereIn('id', $ids)->update(['visible' => false]);
                    $message = 'चयन गरिएका होस्टेलहरू लुकाइयो।';
                    break;
                case 'show':
                    Hostel::whereIn('id', $ids)->update(['visible' => true]);
                    $message = 'चयन गरिएका होस्टेलहरू देखाइयो।';
                    break;
                case 'delete':
                    Hostel::whereIn('id', $ids)->delete();
                    $message = 'चयन गरिएका होस्टेलहरू मेटियो।';
                    break;
            }

            return redirect()->route('admin.hostels.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'केही त्रुटि भयो: ' . $e->getMessage());
        }
    }
}