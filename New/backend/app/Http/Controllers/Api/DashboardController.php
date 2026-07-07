<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jobs;
use App\Models\Registration;
use App\Models\Report;
use App\Models\WorkflowStage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        $user = $request->user();
        $isAdmin = (bool) ($user?->isLegacyAdmin() ?? $user?->is_admin ?? false);
        $today = now()->toDateString();

        // Legacy metrics (existing)
        $totalRegistration = Registration::query()->count();
        $totalAmount = (float) Registration::query()->sum('total_payment');
        $totalReceivedAmount = (float) Registration::query()->sum('advance_payment');
        $totalBalanceAmount = (float) Registration::query()->sum('balance_dues');
        $todayRegistration = Registration::query()->whereDate('received_date', $today)->count();
        $todayAmount = (float) Registration::query()->whereDate('received_date', $today)->sum('total_payment');
        $todayReceivedAmount = (float) Registration::query()->whereDate('received_date', $today)->sum('advance_payment');
        $todayBalanceAmount = (float) Registration::query()->whereDate('received_date', $today)->sum('balance_dues');
        $totalReports = Report::query()->count();
        $pendingReports = Report::query()->where('status', 'Pending')->count();
        $todayReports = Report::query()->whereDate('create_date', $today)->count();

        // Job-based metrics (new workflow)
        $jobsToday = Jobs::whereDate('created_at', $today)->count();
        $jobsPendingReview = Jobs::whereHas('currentStage', fn ($q) => $q->where('slug', 'technical-review'))->count();
        $jobsPendingApproval = Jobs::whereHas('currentStage', fn ($q) => $q->where('slug', 'approval'))->count();
        $jobsPendingBilling = Jobs::whereHas('currentStage', fn ($q) => $q->where('slug', 'billing'))->count();
        $jobsPendingDispatch = Jobs::whereHas('currentStage', fn ($q) => $q->where('slug', 'dispatch'))->count();
        $jobsCompleted = Jobs::where('status', 'completed')->count();
        $jobsActive = Jobs::where('status', 'active')->count();
        $jobsCompletedToday = Jobs::where('status', 'completed')->whereDate('completed_at', $today)->count();

        // Overdue jobs (SLA breach)
        $overdueJobs = Jobs::whereHas('activeStageTracking', fn ($q) => $q->where('is_overdue', true))->count();

        // My pending tasks (based on assigned user)
        $myPendingJobs = Jobs::where('assigned_to', $user?->id)
            ->whereIn('status', ['pending', 'active'])
            ->count();

        // My pending review (if user is a reviewer/approver)
        $myPendingReviews = Jobs::whereHas('currentStage', fn ($q) => $q->whereIn('slug', ['technical-review', 'approval']))
            ->where('assigned_to', $user?->id)
            ->whereIn('status', ['pending', 'active'])
            ->count();

        return response()->json([
            'page_title' => 'Dashboard',
            'is_admin' => $isAdmin,
            'metrics' => [
                // Legacy
                'total_registration' => $totalRegistration,
                'total_reports' => $totalReports,
                'pending_reports' => $pendingReports,
                'total_amount' => $totalAmount,
                'total_cash_amount' => 0,
                'total_received_amount' => $totalReceivedAmount,
                'today_registration' => $todayRegistration,
                'today_reports' => $todayReports,
                'today_amount' => $todayAmount,
                'today_received_amount' => $todayReceivedAmount,
                'today_balance_amount' => $todayBalanceAmount,
                'expenses_this_month' => 0,
                'total_balance_amount' => $totalBalanceAmount,

                // Job-based workflow metrics
                'jobs_today' => $jobsToday,
                'jobs_active' => $jobsActive,
                'jobs_completed' => $jobsCompleted,
                'jobs_completed_today' => $jobsCompletedToday,
                'jobs_pending_review' => $jobsPendingReview,
                'jobs_pending_approval' => $jobsPendingApproval,
                'jobs_pending_billing' => $jobsPendingBilling,
                'jobs_pending_dispatch' => $jobsPendingDispatch,
                'jobs_overdue' => $overdueJobs,
                'my_pending_jobs' => $myPendingJobs,
                'my_pending_reviews' => $myPendingReviews,
            ],
            'modules' => [
                'Auth and users',
                'Registration and billing',
                'Lab reports',
                'Expenses and company settings',
                'Reports and analytics',
            ],
        ]);
    }

    public function cashSummary(): JsonResponse
    {
        $todayCash = DB::table('client_registration')
            ->whereDate('received_date', now()->toDateString())
            ->where('mode_of_payment', 'Cash')
            ->sum('total_payment');

        $todayReceived = DB::table('client_registration')
            ->whereDate('received_date', now()->toDateString())
            ->sum('advance_payment');

        $monthCash = DB::table('client_registration')
            ->whereMonth('received_date', now()->month)
            ->whereYear('received_date', now()->year)
            ->where('mode_of_payment', 'Cash')
            ->sum('total_payment');

        return response()->json([
            'today_cash_total' => (float) $todayCash,
            'today_received_total' => (float) $todayReceived,
            'month_cash_total' => (float) $monthCash,
        ]);
    }

    public function trends(Request $request): JsonResponse
    {
        $months = (int) ($request->query('months', 12));

        $monthlyRegistrations = DB::table('client_registration')
            ->select(
                DB::raw("DATE_FORMAT(received_date, '%Y-%m') as month"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CAST(total_payment AS DECIMAL(12,2))) as total_amount'),
                DB::raw('SUM(CAST(advance_payment AS DECIMAL(12,2))) as received_amount'),
                DB::raw('SUM(CAST(balance_dues AS DECIMAL(12,2))) as balance_amount'),
            )
            ->whereRaw("received_date >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)", [$months])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $reportStatusCounts = DB::table('reports')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $today = now()->toDateString();
        $todayReports = Report::query()->whereDate('create_date', $today)->count();

        return response()->json([
            'monthly_registrations' => $monthlyRegistrations,
            'report_statuses' => [
                'total' => array_sum($reportStatusCounts),
                'pending' => (int) ($reportStatusCounts['Pending'] ?? 0),
                'complete' => (int) ($reportStatusCounts['Complete'] ?? 0),
                'cancel' => (int) ($reportStatusCounts['Cancel'] ?? 0),
            ],
            'today_reports' => $todayReports,
        ]);
    }
}
