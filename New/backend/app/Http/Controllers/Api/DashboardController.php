<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Report;
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

        return response()->json([
            'page_title' => 'Dashboard',
            'is_admin' => $isAdmin,
            'metrics' => [
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
