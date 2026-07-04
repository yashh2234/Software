<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterReport extends Model
{
    protected $table = 'water_report';
    protected $primaryKey = 'iWaterId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iWaterId', 'iReportId', 'uid_no', 'source_of_water', 'location',
        'date_of_sampling', 'date_of_testing', 'ph_value', 'turbidity',
        'tds', 'hardness', 'alkalinity', 'chloride', 'sulphate', 'iron',
        'create_date', 'set_count',
    ];
}
