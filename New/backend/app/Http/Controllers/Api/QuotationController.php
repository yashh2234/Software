<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with(['inquiry', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('inquiry_id')) {
            $query->where('inquiry_id', $request->inquiry_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_no', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('agency_name', 'like', "%{$search}%");
            });
        }

        $quotations = $query->orderByDesc('id')->paginate($request->get('per_page', 25));
        return response()->json($quotations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inquiry_id' => 'nullable|integer',
            'client_name' => 'required|string|max:222',
            'agency_name' => 'nullable|string|max:222',
            'contact_person' => 'nullable|string|max:222',
            'mobile_no' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:222',
            'date' => 'required|date',
            'valid_until' => 'nullable|date',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'terms_and_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['rate'];
            }

            $discount = $validated['discount'] ?? 0;
            $taxAmount = $validated['tax_amount'] ?? 0;
            $netAmount = $totalAmount - $discount + $taxAmount;

            $quotation = Quotation::create([
                'inquiry_id' => $validated['inquiry_id'] ?? null,
                'quotation_no' => Quotation::generateQuotationNo(),
                'date' => $validated['date'],
                'valid_until' => $validated['valid_until'] ?? null,
                'client_name' => $validated['client_name'],
                'agency_name' => $validated['agency_name'] ?? null,
                'contact_person' => $validated['contact_person'] ?? null,
                'mobile_no' => $validated['mobile_no'] ?? null,
                'email' => $validated['email'] ?? null,
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax_amount' => $taxAmount,
                'net_amount' => $netAmount,
                'terms_and_conditions' => $validated['terms_and_conditions'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $index => $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'nos',
                    'rate' => $item['rate'],
                    'amount' => $item['quantity'] * $item['rate'],
                    'sort_order' => $index,
                ]);
            }

            return response()->json($quotation->load('items'), 201);
        });
    }

    public function show(Quotation $quotation)
    {
        return response()->json($quotation->load(['inquiry', 'items', 'workOrders']));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'client_name' => 'sometimes|string|max:222',
            'agency_name' => 'nullable|string|max:222',
            'contact_person' => 'nullable|string|max:222',
            'mobile_no' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:222',
            'date' => 'sometimes|date',
            'valid_until' => 'nullable|date',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'terms_and_conditions' => 'nullable|string',
            'status' => 'sometimes|in:draft,sent,accepted,rejected,expired',
            'sent_via' => 'nullable|in:email,phone,hand_delivery,courier',
            'notes' => 'nullable|string',
            'items' => 'sometimes|array|min:1',
        ]);

        if (isset($validated['items'])) {
            $quotation->items()->delete();
            $totalAmount = 0;
            foreach ($validated['items'] as $index => $item) {
                $amount = $item['quantity'] * $item['rate'];
                $totalAmount += $amount;
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'nos',
                    'rate' => $item['rate'],
                    'amount' => $amount,
                    'sort_order' => $index,
                ]);
            }
            $validated['total_amount'] = $totalAmount;
            $discount = $validated['discount'] ?? $quotation->discount;
            $taxAmount = $validated['tax_amount'] ?? $quotation->tax_amount;
            $validated['net_amount'] = $totalAmount - $discount + $taxAmount;
            unset($validated['items']);
        }

        if (isset($validated['status']) && $validated['status'] === 'sent' && !$quotation->sent_at) {
            $validated['sent_at'] = now();
        }
        if (isset($validated['status']) && $validated['status'] === 'accepted' && !$quotation->accepted_at) {
            $validated['accepted_at'] = now();
        }

        $quotation->update($validated);
        return response()->json($quotation->load('items'));
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->items()->delete();
        $quotation->delete();
        return response()->json(['message' => 'Quotation deleted']);
    }

    public function printDiv(Quotation $quotation)
    {
        return response()->json($quotation->load(['inquiry', 'items']));
    }
}
