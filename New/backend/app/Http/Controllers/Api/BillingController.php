<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Registration;
use App\Models\SmsReminderLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Billing::query()
            ->leftJoin('client_registration', 'billing.uid_no', '=', 'client_registration.uid_no')
            ->select(
                'billing.id',
                'billing.uid_no',
                'billing.bill_no',
                'billing.bill_amount',
                'billing.advance_amount',
                'billing.mode_of_payment',
                'billing.amount_received',
                'billing.amount_received_date',
                'billing.due_amount',
                'billing.discount',
                'billing.payment_followup',
                'billing.remark',
                'billing.created_date',
                'client_registration.agency_name',
                'client_registration.mobile_no'
            );

        if ($request->filled('start_date')) {
            $query->whereDate('billing.created_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('billing.created_date', '<=', $request->end_date);
        }

        $perPage = $request->input('per_page', 20);
        $billings = $query->orderByDesc('billing.id')->paginate($perPage);

        return response()->json($billings);
    }

    public function due(Request $request): JsonResponse
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Registration::query()->where('balance_dues', '>', 0);

        if ($startDate && $endDate) {
            $query->whereDate('received_date', '>=', $startDate)
                ->whereDate('received_date', '<=', $endDate);
        }

        $bills = $query
            ->orderByDesc('received_date')
            ->orderByDesc('iClientId')
            ->get()
            ->map(function (Registration $registration): array {
                $totalPayment = (float) ($registration->total_payment ?: 0);
                $advancePayment = (float) ($registration->advance_payment ?: 0);
                $balanceDues = (float) ($registration->balance_dues ?: 0);

                $status = 'Due';
                $color = 'red';
                if ($balanceDues === 0.0 && $totalPayment > 0) {
                    $color = 'green';
                    $status = 'Paid';
                } elseif ($balanceDues > 0 && $totalPayment > 0) {
                    $color = 'yellow';
                    $status = 'Partial';
                }

                return [
                    'id' => $registration->iClientId,
                    'uid_no' => $registration->uid_no,
                    'received_date' => optional($registration->received_date)->format('d/m/Y'),
                    'agency_name' => $registration->agency_name,
                    'reporting_address' => $registration->reporting_address,
                    'mobile_no' => $registration->mobile_no,
                    'total_payment' => $totalPayment,
                    'advance_payment' => $advancePayment,
                    'balance_dues' => $balanceDues,
                    'payment_followup' => $registration->payment_followup,
                    'financial_remark' => $registration->financial_remark,
                    'mode_of_payment' => $registration->mode_of_payment,
                    'remark' => $registration->remark,
                    'sample_details' => $registration->sample_details,
                    'qty' => $registration->qty,
                    'status' => $status,
                    'color' => $color,
                ];
            });

        return response()->json([
            'count' => $bills->count(),
            'total_due' => $bills->sum('balance_dues'),
            'data' => $bills,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'uid_no' => 'required|string',
            'bill_no' => 'required|string',
            'bill_amount' => 'required|numeric',
            'advance_amount' => 'nullable|numeric',
            'mode_of_payment' => 'nullable|string',
            'amount_received' => 'nullable|numeric',
            'amount_received_date' => 'nullable|date',
            'due_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'payment_followup' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);

        $billing = Billing::create($validated);

        return response()->json(['message' => 'Billing record created', 'data' => $billing], 201);
    }

    public function show($id): JsonResponse
    {
        $billing = Billing::query()
            ->leftJoin('client_registration', 'billing.uid_no', '=', 'client_registration.uid_no')
            ->select(
                'billing.id',
                'billing.uid_no',
                'billing.bill_no',
                'billing.bill_amount',
                'billing.advance_amount',
                'billing.mode_of_payment',
                'billing.amount_received',
                'billing.amount_received_date',
                'billing.due_amount',
                'billing.discount',
                'billing.payment_followup',
                'billing.remark',
                'billing.created_date',
                'client_registration.agency_name',
                'client_registration.mobile_no'
            )
            ->where('billing.id', $id)
            ->firstOrFail();

        return response()->json(['data' => $billing]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $billing = Billing::findOrFail($id);

        $validated = $request->validate([
            'uid_no' => 'sometimes|string',
            'bill_no' => 'sometimes|string',
            'bill_amount' => 'sometimes|numeric',
            'advance_amount' => 'nullable|numeric',
            'mode_of_payment' => 'nullable|string',
            'amount_received' => 'nullable|numeric',
            'amount_received_date' => 'nullable|date',
            'due_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'payment_followup' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);

        $billing->update($validated);

        return response()->json(['message' => 'Billing record updated', 'data' => $billing]);
    }

    public function destroy($id): JsonResponse
    {
        $billing = Billing::findOrFail($id);
        $billing->delete();

        return response()->json(['message' => 'Billing record deleted']);
    }

    public function updateRegistration(Request $request, $id): JsonResponse
    {
        $registration = Registration::findOrFail($id);

        $validated = $request->validate([
            'total_payment' => 'nullable|numeric',
            'advance_payment' => 'nullable|numeric',
            'balance_dues' => 'nullable|numeric',
            'payment_followup' => 'nullable|string',
            'financial_remark' => 'nullable|string',
            'mode_of_payment' => 'nullable|string',
        ]);

        $registration->update($validated);

        return response()->json(['message' => 'Registration billing fields updated', 'data' => $registration]);
    }

    public function sendSms(Request $request): JsonResponse
    {
        $request->validate(['id' => 'required|integer']);

        $client = Registration::find($request->id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $mobile = $client->mobile_no;
        if (empty($mobile)) {
            return response()->json(['message' => 'Client has no mobile number'], 400);
        }

        $balanceDues = (float) ($client->balance_dues ?: 0);

        $message = "Hello {$client->agency_name}, This is a friendly reminder, your payment of Rs{$balanceDues} is due. You may pay by visiting our office. Ignore if paid already. Thank you From Namotech";

        $apiKey = 'NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=';
        $sender = 'NAMOTH';
        $numbers = $mobile;

        $url = "https://api.textlocal.in/send/?apikey={$apiKey}&sender={$sender}&numbers={$numbers}&message=" . urlencode($message);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        SmsReminderLog::create([
            'iClientId' => $client->iClientId,
            'sent_date' => now(),
            'balance_amount' => $balanceDues,
            'advance_amount' => $client->advance_payment,
            'total_amount' => $client->total_payment,
        ]);

        if ($httpCode === 200 && isset($result['status']) && $result['status'] === 'success') {
            return response()->json(['message' => 'SMS sent successfully', 'response' => $result]);
        }

        return response()->json(['message' => 'SMS sending failed or partial', 'response' => $result], 200);
    }

    public function sendAllSms(): JsonResponse
    {
        $clients = Registration::where('balance_dues', '>', 0)->get();
        $sent = 0;
        $failed = 0;

        foreach ($clients as $client) {
            $mobile = $client->mobile_no;
            if (empty($mobile)) {
                $failed++;
                continue;
            }

            $balanceDues = (float) ($client->balance_dues ?: 0);

            $message = "Hello {$client->agency_name}, This is a friendly reminder, your payment of Rs{$balanceDues} is due. You may pay by visiting our office. Ignore if paid already. Thank you From Namotech";

            $apiKey = 'NTI0ODRkNGQ1NjYxMzI0MzRlNzc0ZjM0NmU1NDZhMzc=';
            $sender = 'NAMOTH';
            $numbers = $mobile;

            $url = "https://api.textlocal.in/send/?apikey={$apiKey}&sender={$sender}&numbers={$numbers}&message=" . urlencode($message);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            SmsReminderLog::create([
                'iClientId' => $client->iClientId,
                'sent_date' => now(),
                'balance_amount' => $balanceDues,
                'advance_amount' => $client->advance_payment,
                'total_amount' => $client->total_payment,
            ]);

            if ($httpCode === 200 && isset($result['status']) && $result['status'] === 'success') {
                $sent++;
            } else {
                $failed++;
            }
        }

        return response()->json([
            'message' => "SMS sent to {$sent} clients" . ($failed > 0 ? ", {$failed} failed" : ''),
            'sent' => $sent,
            'failed' => $failed,
        ]);
    }

    public function smsLog(): JsonResponse
    {
        $logs = SmsReminderLog::query()
            ->leftJoin('client_registration', 'sms_reminder_log.iClientId', '=', 'client_registration.iClientId')
            ->select(
                'sms_reminder_log.id',
                'sms_reminder_log.iClientId',
                'sms_reminder_log.sent_date',
                'sms_reminder_log.balance_amount',
                'sms_reminder_log.advance_amount',
                'sms_reminder_log.total_amount',
                'client_registration.agency_name',
                'client_registration.mobile_no',
                'client_registration.uid_no'
            )
            ->orderByDesc('sms_reminder_log.id')
            ->get();

        return response()->json(['data' => $logs]);
    }
}
