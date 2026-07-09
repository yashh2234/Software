<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs as JobsModel;
use App\Models\AuditLog;
use App\Models\Registration;
use App\Models\Report;
use App\Models\UserActivity;
use App\Models\WorkflowStage;
use App\Models\WorkflowTemplate;
use App\Models\WorkflowTransition;
use App\Services\WorkflowEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $registrations = Registration::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate): void {
                $query->whereDate('received_date', '>=', $startDate)
                    ->whereDate('received_date', '<=', $endDate);
            })
            ->orderByDesc('iClientId')
            ->limit(25)
            ->get()
            ->map(function (Registration $registration): array {
                $totalPayment = (float) ($registration->total_payment ?: 0);
                $advancePayment = (float) ($registration->advance_payment ?: 0);
                $balanceDues = (float) ($registration->balance_dues ?: 0);

                return [
                    'id' => $registration->iClientId,
                    'uid_no' => $registration->uid_no,
                    'received_date' => $this->formatLegacyDate($registration->received_date),
                    'agency_name' => $registration->agency_name,
                    'reporting_address' => $registration->reporting_address,
                    'mobile_no' => $registration->mobile_no,
                    'name_of_work' => $registration->name_of_work,
                    'sample_details' => $registration->sample_details,
                    'sample_details_1' => $registration->sample_details_1 ?? '',
                    'sample_details_2' => $registration->sample_details_2 ?? '',
                    'sample_details_3' => $registration->sample_details_3 ?? '',
                    'sample_details_4' => $registration->sample_details_4 ?? '',
                    'total_payment' => $totalPayment,
                    'advance_payment' => $advancePayment,
                    'balance_dues' => $balanceDues,
                    'payment_followup' => $registration->payment_followup,
                    'remark' => $registration->remark,
                    'qty' => $registration->qty,
                    'qty_1' => $registration->qty_1 ?? '',
                    'qty_2' => $registration->qty_2 ?? '',
                    'qty_3' => $registration->qty_3 ?? '',
                    'qty_4' => $registration->qty_4 ?? '',
                    'assign_to' => $registration->assign_to,
                    'report_copy' => $registration->report_copy,
                    'status' => $balanceDues > 0 ? 'Pending' : 'Complete',
                ];
            });

        return response()->json([
            'data' => $registrations,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'uid_no' => ['required', 'string', 'max:255'],
            'received_date' => ['required', 'string', 'max:255'],
            'agency_name' => ['required', 'string', 'max:255'],
            'reporting_address' => ['required', 'string', 'max:255'],
            'mobile_no' => ['required', 'string', 'max:50'],
            'name_of_work' => ['required', 'string'],
            'sample_details' => ['required', 'string'],
            'sample_details_1' => ['nullable', 'string'],
            'sample_details_2' => ['nullable', 'string'],
            'sample_details_3' => ['nullable', 'string'],
            'sample_details_4' => ['nullable', 'string'],
            'total_payment' => ['nullable', 'numeric'],
            'advance_payment' => ['nullable', 'numeric'],
            'balance_dues' => ['nullable', 'numeric'],
            'payment_followup' => ['nullable', 'string', 'max:255'],
            'remark' => ['nullable', 'string'],
            'qty' => ['nullable', 'string', 'max:255'],
            'qty_1' => ['nullable', 'string', 'max:255'],
            'qty_2' => ['nullable', 'string', 'max:255'],
            'qty_3' => ['nullable', 'string', 'max:255'],
            'qty_4' => ['nullable', 'string', 'max:255'],
            'assign_to' => ['nullable', 'string', 'max:255'],
        ]);

        $registration = DB::transaction(function () use ($validated) {
            $nextId = ((int) (DB::table('client_registration')->max('iClientId') ?? 0)) + 1;
            $nextSno = ((int) (DB::table('client_registration')->max('sno') ?? 0)) + 1;

            DB::table('client_registration')->insert([
                'iClientId' => $nextId,
                'sno' => $nextSno,
                'uid_no' => $validated['uid_no'],
                'ulr_no' => '',
                'month' => '',
                'received_date' => $this->normalizeLegacyDate($validated['received_date']),
                'agency_name' => $validated['agency_name'],
                'mobile_no' => $validated['mobile_no'],
                'reporting_address' => $validated['reporting_address'],
                'name_of_work' => $validated['name_of_work'],
                'work' => '',
                'work_order_no' => '',
                'reference' => '',
                'dist' => '',
                'payment_followup' => $validated['payment_followup'] ?? '',
                'advance_payment' => (string) ($validated['advance_payment'] ?? 0),
                'balance_dues' => (string) ($validated['balance_dues'] ?? 0),
                'total_payment' => (string) ($validated['total_payment'] ?? 0),
                'financial_remark' => '',
                'mode_of_payment' => '',
                'new_back' => '',
                'new_back_1' => '',
                'new_back_2' => '',
                'new_back_3' => '',
                'new_back_4' => '',
                'sample_details' => $validated['sample_details'],
                'sample_details_1' => $validated['sample_details_1'] ?? '',
                'sample_details_2' => $validated['sample_details_2'] ?? '',
                'sample_details_3' => $validated['sample_details_3'] ?? '',
                'sample_details_4' => $validated['sample_details_4'] ?? '',
                'qty_1' => $validated['qty_1'] ?? '',
                'qty_2' => $validated['qty_2'] ?? '',
                'qty_3' => $validated['qty_3'] ?? '',
                'qty_4' => $validated['qty_4'] ?? '',
                'sample_test' => '',
                'qty' => $validated['qty'] ?? '',
                'witness' => '',
                'field_person_name' => '',
                'remark' => $validated['remark'] ?? '',
                'sample_remark' => '',
                'prepared_date' => '',
                'report_no' => '',
                'dispatch_date' => '',
                'report_status' => 'Pending',
                'report_copy' => '',
                'gst_no' => '',
                'sample_nos' => '',
                'scan_copy' => '',
                'scan_copy_1' => '',
                'scan_copy_2' => '',
                'scan_copy_3' => '',
                'scan_copy_4' => '',
                'assign_to' => $validated['assign_to'] ?? 'lab',
            ]);

            return DB::table('client_registration')->where('iClientId', $nextId)->first();
        });

        UserActivity::query()->create([
            'user_id' => $request->user()->id,
            'action' => 'sample_registered',
            'module' => 'registrations',
            'details' => "Registered sample {$validated['uid_no']}",
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        $this->syncJobFromRegistration($registration, $request);

        return response()->json([
            'message' => 'Registration created successfully',
            'registration' => $this->presentRegistration($registration),
        ], 201);
    }

    public function update(Request $request, int $registrationId): JsonResponse
    {
        $validated = $request->validate([
            'uid_no' => ['required', 'string', 'max:255'],
            'received_date' => ['required', 'string', 'max:255'],
            'agency_name' => ['required', 'string', 'max:255'],
            'reporting_address' => ['required', 'string', 'max:255'],
            'mobile_no' => ['required', 'string', 'max:50'],
            'name_of_work' => ['required', 'string'],
            'sample_details' => ['required', 'string'],
            'sample_details_1' => ['nullable', 'string'],
            'sample_details_2' => ['nullable', 'string'],
            'sample_details_3' => ['nullable', 'string'],
            'sample_details_4' => ['nullable', 'string'],
            'total_payment' => ['nullable', 'numeric'],
            'advance_payment' => ['nullable', 'numeric'],
            'balance_dues' => ['nullable', 'numeric'],
            'payment_followup' => ['nullable', 'string', 'max:255'],
            'remark' => ['nullable', 'string'],
            'qty' => ['nullable', 'string', 'max:255'],
            'qty_1' => ['nullable', 'string', 'max:255'],
            'qty_2' => ['nullable', 'string', 'max:255'],
            'qty_3' => ['nullable', 'string', 'max:255'],
            'qty_4' => ['nullable', 'string', 'max:255'],
            'assign_to' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('client_registration')->where('iClientId', $registrationId)->update([
            'uid_no' => $validated['uid_no'],
            'received_date' => $this->normalizeLegacyDate($validated['received_date']),
            'agency_name' => $validated['agency_name'],
            'reporting_address' => $validated['reporting_address'],
            'mobile_no' => $validated['mobile_no'],
            'name_of_work' => $validated['name_of_work'],
            'sample_details' => $validated['sample_details'],
            'sample_details_1' => $validated['sample_details_1'] ?? '',
            'sample_details_2' => $validated['sample_details_2'] ?? '',
            'sample_details_3' => $validated['sample_details_3'] ?? '',
            'sample_details_4' => $validated['sample_details_4'] ?? '',
            'total_payment' => (string) ($validated['total_payment'] ?? 0),
            'advance_payment' => (string) ($validated['advance_payment'] ?? 0),
            'balance_dues' => (string) ($validated['balance_dues'] ?? 0),
            'payment_followup' => $validated['payment_followup'] ?? '',
            'qty' => $validated['qty'] ?? '',
            'qty_1' => $validated['qty_1'] ?? '',
            'qty_2' => $validated['qty_2'] ?? '',
            'qty_3' => $validated['qty_3'] ?? '',
            'qty_4' => $validated['qty_4'] ?? '',
            'remark' => $validated['remark'] ?? '',
            'assign_to' => $validated['assign_to'] ?? 'lab',
        ]);

        $registration = DB::table('client_registration')->where('iClientId', $registrationId)->first();

        abort_if(! $registration, 404, 'Registration not found');

        $this->syncJobFromRegistration($registration, $request);

        return response()->json([
            'message' => 'Registration updated successfully',
            'registration' => $this->presentRegistration($registration),
        ]);
    }

    private function presentRegistration(object $registration): array
    {
        $totalPayment = (float) ($registration->total_payment ?: 0);
        $advancePayment = (float) ($registration->advance_payment ?: 0);
        $balanceDues = (float) ($registration->balance_dues ?: 0);

        return [
            'id' => $registration->iClientId,
            'uid_no' => $registration->uid_no,
            'received_date' => $this->formatLegacyDate($registration->received_date),
            'agency_name' => $registration->agency_name,
            'reporting_address' => $registration->reporting_address,
            'mobile_no' => $registration->mobile_no,
            'name_of_work' => $registration->name_of_work,
            'sample_details' => $registration->sample_details,
            'sample_details_1' => $registration->sample_details_1 ?? '',
            'sample_details_2' => $registration->sample_details_2 ?? '',
            'sample_details_3' => $registration->sample_details_3 ?? '',
            'sample_details_4' => $registration->sample_details_4 ?? '',
            'total_payment' => $totalPayment,
            'advance_payment' => $advancePayment,
            'balance_dues' => $balanceDues,
            'payment_followup' => $registration->payment_followup,
            'remark' => $registration->remark,
            'qty' => $registration->qty,
            'qty_1' => $registration->qty_1 ?? '',
            'qty_2' => $registration->qty_2 ?? '',
            'qty_3' => $registration->qty_3 ?? '',
            'qty_4' => $registration->qty_4 ?? '',
            'assign_to' => $registration->assign_to,
            'report_copy' => $registration->report_copy,
            'status' => $balanceDues > 0 ? 'Pending' : 'Complete',
        ];
    }

    public function searchCustomers(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        if (strlen($query) < 2) {
            return response()->json(['data' => []]);
        }

        $registrations = Registration::query()
            ->where('agency_name', 'like', "%{$query}%")
            ->orWhere('mobile_no', 'like', "%{$query}%")
            ->orWhere('uid_no', 'like', "%{$query}%")
            ->orderByDesc('iClientId')
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'iClientId' => $r->iClientId,
                'uid_no' => $r->uid_no,
                'agency_name' => $r->agency_name,
                'reporting_address' => $r->reporting_address,
                'mobile_no' => $r->mobile_no,
                'name_of_work' => $r->name_of_work,
            ]);

        return response()->json(['data' => $registrations]);
    }

    public function generateUid(): JsonResponse
    {
        $year = now()->format('Y');
        $lastSno = (int) DB::table('client_registration')
            ->whereYear('received_date', $year)
            ->max('sno');

        $nextSno = max($lastSno, 0) + 1;
        $uid = sprintf('NAMO/MC/%s/%05d', $year, $nextSno);

        return response()->json([
            'uid_no' => $uid,
            'sno' => $nextSno,
            'year' => $year,
        ]);
    }

    public function history(int $registrationId): JsonResponse
    {
        $registration = Registration::query()->where('iClientId', $registrationId)->firstOrFail();

        $entries = [];

        if ($registration->received_date) {
            $entries[] = ['event' => 'Registration Created', 'timestamp' => $registration->received_date->toIso8601String(), 'icon' => 'file'];
        }

        $reports = Report::query()->where('uid_no', $registration->uid_no)->orderBy('create_date')->get();
        foreach ($reports as $report) {
            $entries[] = ['event' => "Report {$report->uid_no} created ({$report->report_type})", 'timestamp' => optional($report->create_date)->toIso8601String(), 'icon' => 'file_text'];
            if ($report->assigned_at) {
                $entries[] = ['event' => "Report assigned for testing", 'timestamp' => $report->assigned_at->toIso8601String(), 'icon' => 'user'];
            }
            if ($report->testing_started_at) {
                $entries[] = ['event' => "Testing started", 'timestamp' => $report->testing_started_at->toIso8601String(), 'icon' => 'play'];
            }
            if ($report->report_generated_at) {
                $entries[] = ['event' => "Report generated", 'timestamp' => $report->report_generated_at->toIso8601String(), 'icon' => 'file_text'];
            }
            if ($report->approved_at) {
                $entries[] = ['event' => "Report approved", 'timestamp' => $report->approved_at->toIso8601String(), 'icon' => 'check'];
            }
            if ($report->status === 'Cancel') {
                $entries[] = ['event' => "Report canceled: {$report->cancel_remark}", 'timestamp' => optional($report->updated_date)->toIso8601String(), 'icon' => 'x'];
            }
        }

        $auditLogs = AuditLog::query()
            ->where('model_type', 'Registration')
            ->where('model_id', $registrationId)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        foreach ($auditLogs as $log) {
            $entries[] = ['event' => $log->description ?? $log->action, 'timestamp' => optional($log->created_at)->toIso8601String(), 'icon' => 'audit', 'user' => $log->user?->name ?? 'System'];
        }

        usort($entries, fn($a, $b) => ($b['timestamp'] ?? '') <=> ($a['timestamp'] ?? ''));

        return response()->json(['data' => $entries, 'uid_no' => $registration->uid_no]);
    }

    public function uploadScan(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'field' => ['required', 'string', 'in:scan_copy,scan_copy_1,scan_copy_2,scan_copy_3,scan_copy_4'],
            'registration_id' => ['required', 'integer'],
        ]);

        $file = $request->file('file');
        $path = $file->store('scans', 'public');

        DB::table('client_registration')
            ->where('iClientId', $request->input('registration_id'))
            ->update([$request->input('field') => $path]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
            'url' => asset("storage/$path"),
        ]);
    }

    protected function syncJobFromRegistration(object $registration, Request $request): void
    {
        $template = WorkflowTemplate::where('is_active', true)->first();
        if (!$template) return;

        $existingJob = JobsModel::where('uid_no', $registration->uid_no)->first();
        if ($existingJob) {
            $this->linkJobToRegistration($registration, $existingJob);
            $regStage = WorkflowStage::where('template_id', $template->id)
                ->where('slug', 'registration')->first();
            if ($regStage && $existingJob->current_stage_id !== $regStage->id) {
                $transition = WorkflowTransition::where('template_id', $template->id)
                    ->where('from_stage_id', $existingJob->current_stage_id)
                    ->where('to_stage_id', $regStage->id)
                    ->first();
                if ($transition) {
                    app(WorkflowEngine::class)->transition(
                        $existingJob, $transition, $request->user(), 'Sample registered'
                    );
                }
            }
            return;
        }

        $job = JobsModel::create([
            'uid_no' => $registration->uid_no,
            'title' => 'Registration ' . $registration->uid_no,
            'priority' => 'normal',
            'workflow_template_id' => $template->id,
            'created_by' => $request->user()?->id,
            'status' => 'pending',
        ]);

        $this->linkJobToRegistration($registration, $job);

        app(WorkflowEngine::class)->startJob($job, $request->user());

        $regStage = WorkflowStage::where('template_id', $template->id)
            ->where('slug', 'registration')->first();
        if ($regStage && $job->current_stage_id !== $regStage->id) {
            $transition = WorkflowTransition::where('template_id', $template->id)
                ->where('from_stage_id', $job->current_stage_id)
                ->where('to_stage_id', $regStage->id)
                ->first();
            if ($transition) {
                app(WorkflowEngine::class)->transition(
                    $job, $transition, $request->user(), 'Sample registered'
                );
            }
        }
    }

    protected function linkJobToRegistration(object $registration, JobsModel $job): void
    {
        DB::table('client_registration')
            ->where('iClientId', $registration->iClientId)
            ->update(['job_id' => $job->id]);
    }

    private function normalizeLegacyDate(mixed $value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        $dateValue = trim((string) $value);

        foreach (['Y-m-d', 'd/m/Y'] as $format) {
            try {
                return Carbon::createFromFormat($format, $dateValue)->format('Y-m-d');
            } catch (\Throwable) {
                // Try the next format.
            }
        }

        return Carbon::parse($dateValue)->format('Y-m-d');
    }

    private function formatLegacyDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('d/m/Y');
        }

        $dateValue = trim((string) $value);

        foreach (['Y-m-d', 'd/m/Y'] as $format) {
            try {
                return Carbon::createFromFormat($format, $dateValue)->format('d/m/Y');
            } catch (\Throwable) {
                // Try the next format.
            }
        }

        try {
            return Carbon::parse($dateValue)->format('d/m/Y');
        } catch (\Throwable) {
            return $dateValue;
        }
    }
}