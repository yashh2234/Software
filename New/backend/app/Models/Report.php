<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'iReportId';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'iReportId',
        'uid_no',
        'ulr_no',
        'customer_details',
        'agency_name',
        'reference_no',
        'material_details',
        'source_location',
        'work_order_no',
        'sample_date',
        'sample_tested_date',
        'dispatch_date',
        'sampled_by',
        'environment_condition',
        'report_type',
        'status',
        'cancel_remark',
        'user_id',
        'updated_by',
        'updated_date',
        'create_date',
        'assigned_to',
        'assigned_at',
        'testing_started_at',
        'report_generated_at',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'sample_date' => 'date',
        'sample_tested_date' => 'date',
        'dispatch_date' => 'date',
        'create_date' => 'datetime',
        'updated_date' => 'datetime',
    ];

    public function cubeReport()
    {
        return $this->hasMany(CubeReport::class, 'iReportId', 'iReportId');
    }
}