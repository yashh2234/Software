<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DueReportsController extends Controller
{
    public function index(): JsonResponse
    {
        $registrations = DB::select('
            SELECT cr.*
            FROM client_registration cr
            WHERE cr.uid_no NOT IN (
                SELECT DISTINCT uid_no FROM reports
            )
            AND (cr.report_no IS NULL OR cr.report_no = \'\')
            AND (cr.report_copy IS NULL OR cr.report_copy = \'\')
            AND cr.received_date < DATE_SUB(NOW(), INTERVAL 7 DAY)
            ORDER BY cr.received_date DESC
        ');

        return response()->json(['data' => $registrations]);
    }
}
