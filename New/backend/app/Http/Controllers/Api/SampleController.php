<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jobs;
use App\Models\Sample;
use App\Models\JobTimeline;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function index(Jobs $job)
    {
        return response()->json($job->samples()->latest()->get());
    }

    public function store(Request $request, Jobs $job)
    {
        $validated = $request->validate([
            'sample_name' => 'nullable|string|max:255',
            'sample_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:100',
            'received_date' => 'nullable|date',
            'collected_by' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ]);

        $validated['job_id'] = $job->id;
        $sample = Sample::create($validated);

        JobTimeline::create([
            'job_id' => $job->id,
            'action' => 'Sample Registered',
            'user_id' => $request->user()?->id,
            'notes' => "Sample: {$sample->sample_name ?? $sample->sample_type ?? 'N/A'} ({$sample->quantity}{$sample->unit})",
        ]);

        return response()->json($sample, 201);
    }

    public function update(Request $request, Sample $sample)
    {
        $validated = $request->validate([
            'sample_name' => 'nullable|string|max:255',
            'sample_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:100',
            'received_date' => 'nullable|date',
            'collected_by' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ]);

        $sample->update($validated);
        return response()->json($sample);
    }

    public function destroy(Sample $sample)
    {
        $sample->delete();
        return response()->json(null, 204);
    }
}
