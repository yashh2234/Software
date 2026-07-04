<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BricksReport extends Model
{
    protected $table = 'bricks_report';
    protected $primaryKey = 'iBricksId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iBricksId', 'iReportId', 'uid_no', 'dimension_length', 'dimension_width',
        'dimension_height', 'weight', 'comp_strength', 'avg_comp_strength',
        'water_absorption', 'avg_water_absorption', 'efflorescence',
        'create_date', 'set_count',
    ];
}
