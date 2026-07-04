<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q', '');

        if (strlen($q) < 2) {
            return response()->json(['data' => []]);
        }

        $term = '%'.$q.'%';

        $registrations = Registration::query()
            ->where('uid_no', 'like', $term)
            ->orWhere('agency_name', 'like', $term)
            ->orWhere('mobile_no', 'like', $term)
            ->orWhere('name_of_work', 'like', $term)
            ->orWhere('reporting_address', 'like', $term)
            ->limit(10)
            ->get()
            ->map(fn (Registration $r): array => [
                'type' => 'registration',
                'id' => $r->id,
                'uid_no' => $r->uid_no,
                'title' => $r->agency_name,
                'subtitle' => $r->name_of_work,
                'mobile' => $r->mobile_no,
            ]);

        $reports = Report::query()
            ->where('uid_no', 'like', $term)
            ->orWhere('agency_name', 'like', $term)
            ->orWhere('customer_details', 'like', $term)
            ->orWhere('ulr_no', 'like', $term)
            ->limit(10)
            ->get()
            ->map(fn (Report $r): array => [
                'type' => 'report',
                'id' => $r->iReportId,
                'uid_no' => $r->uid_no,
                'title' => $r->agency_name,
                'subtitle' => $r->report_type.' - '.$r->status,
                'mobile' => null,
            ]);

        return response()->json([
            'data' => array_merge($registrations->toArray(), $reports->toArray()),
        ]);
    }
}
