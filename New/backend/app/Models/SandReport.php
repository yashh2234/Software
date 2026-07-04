<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SandReport extends Model
{
    protected $table = 'sand_report';
    protected $primaryKey = 'iSandId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iSandId', 'iReportId', 'uid_no', 'source_location', 'type_of_sand',
        'silt_content', 'avg_silt_content', 'bulking_of_sand', 'specific_gravity',
        'fineness_modules', 'water_absorption', 'create_date', 'set_count',
    ];
}
