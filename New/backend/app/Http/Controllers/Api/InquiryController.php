<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::with(['assignedUser', 'createdByUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('inquiry_type')) {
            $query->where('inquiry_type', $request->inquiry_type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('inquiry_no', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('agency_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('mobile_no', 'like', "%{$search}%");
            });
        }
        if ($request->filled('date_from')) {
            $query->where('received_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('received_date', '<=', $request->date_to);
        }

        $inquiries = $query->orderByDesc('id')->paginate($request->get('per_page', 25));
        return response()->json($inquiries);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:222',
            'agency_name' => 'nullable|string|max:222',
            'contact_person' => 'nullable|string|max:222',
            'mobile_no' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:222',
            'inquiry_type' => 'required|in:letter,email,phone,walk_in,reference',
            'scope_of_work' => 'nullable|string',
            'source_location' => 'nullable|string|max:222',
            'priority' => 'required|in:low,normal,high,urgent',
            'notes' => 'nullable|string',
            'received_date' => 'required|date',
            'assigned_to' => 'nullable|integer',
        ]);

        $validated['inquiry_no'] = Inquiry::generateInquiryNo();
        $validated['status'] = 'new';
        $validated['created_by'] = auth()->id();

        $inquiry = Inquiry::create($validated);

        return response()->json($inquiry->load(['assignedUser', 'createdByUser']), 201);
    }

    public function show(Inquiry $inquiry)
    {
        return response()->json($inquiry->load([
            'quotations', 'workOrders', 'assignedUser', 'createdByUser',
        ]));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'client_name' => 'sometimes|string|max:222',
            'agency_name' => 'nullable|string|max:222',
            'contact_person' => 'nullable|string|max:222',
            'mobile_no' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:222',
            'inquiry_type' => 'sometimes|in:letter,email,phone,walk_in,reference',
            'scope_of_work' => 'nullable|string',
            'source_location' => 'nullable|string|max:222',
            'priority' => 'sometimes|in:low,normal,high,urgent',
            'status' => 'sometimes|in:new,contacted,quoted,converted,cancelled',
            'notes' => 'nullable|string',
            'received_date' => 'sometimes|date',
            'contacted_at' => 'nullable|date',
            'assigned_to' => 'nullable|integer',
        ]);

        $inquiry->update($validated);

        return response()->json($inquiry->load(['assignedUser', 'createdByUser']));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return response()->json(['message' => 'Inquiry deleted']);
    }

    public function convertToQuotation(Inquiry $inquiry)
    {
        $inquiry->update(['status' => 'quoted']);
        return response()->json($inquiry);
    }
}
