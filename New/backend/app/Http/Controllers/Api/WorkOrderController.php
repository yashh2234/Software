<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkOrder::with(['inquiry', 'quotation', 'registration', 'outsourceAssignments']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('assignment_type')) {
            $query->where('assignment_type', $request->assignment_type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('work_order_no', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('agency_name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $workOrders = $query->orderByDesc('id')->paginate($request->get('per_page', 25));
        return response()->json($workOrders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inquiry_id' => 'nullable|integer',
            'quotation_id' => 'nullable|integer',
            'registration_id' => 'nullable|integer',
            'client_name' => 'required|string|max:222',
            'agency_name' => 'nullable|string|max:222',
            'contact_person' => 'nullable|string|max:222',
            'mobile_no' => 'nullable|string|max:50',
            'scope_of_work' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|string|max:222',
            'assignment_type' => 'required|in:inhouse,outsource',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['work_order_no'] = WorkOrder::generateWorkOrderNo();
        $validated['balance_dues'] = ($validated['total_amount'] ?? 0) - ($validated['advance_payment'] ?? 0);
        $validated['status'] = 'active';
        $validated['created_by'] = auth()->id();

        $workOrder = WorkOrder::create($validated);

        return response()->json($workOrder->load(['inquiry', 'quotation', 'registration']), 201);
    }

    public function show(WorkOrder $workOrder)
    {
        return response()->json($workOrder->load([
            'inquiry', 'quotation', 'registration', 'dispatches', 'outsourceAssignments',
        ]));
    }

    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'client_name' => 'sometimes|string|max:222',
            'agency_name' => 'nullable|string|max:222',
            'contact_person' => 'nullable|string|max:222',
            'mobile_no' => 'nullable|string|max:50',
            'scope_of_work' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
            'total_amount' => 'sometimes|numeric|min:0',
            'advance_payment' => 'sometimes|numeric|min:0',
            'payment_terms' => 'nullable|string|max:222',
            'status' => 'sometimes|in:draft,active,in_progress,completed,cancelled',
            'assignment_type' => 'sometimes|in:inhouse,outsource',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['total_amount']) || isset($validated['advance_payment'])) {
            $total = $validated['total_amount'] ?? $workOrder->total_amount;
            $advance = $validated['advance_payment'] ?? $workOrder->advance_payment;
            $validated['balance_dues'] = $total - $advance;
        }

        $workOrder->update($validated);
        return response()->json($workOrder->load(['inquiry', 'quotation', 'registration']));
    }

    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();
        return response()->json(['message' => 'Work order deleted']);
    }

    public function printDiv(WorkOrder $workOrder)
    {
        return response()->json($workOrder->load(['inquiry', 'quotation', 'registration', 'outsourceAssignments']));
    }
}
