<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainholecoverReport extends Model
{
    protected $table = 'mainholecover_report';
    protected $primaryKey = 'iMainholeId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iMainholeId', 'iReportId', 'uid_no', 'cover_type', 'location',
        'size', 'date_of_sample', 'date_of_testing', 'applying_of_load',
        'observation', 'remark', 'create_date', 'set_count',
    ];
}
