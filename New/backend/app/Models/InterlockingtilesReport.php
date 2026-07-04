<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterlockingtilesReport extends Model
{
    protected $table = 'interlockingtiles_report';
    protected $primaryKey = 'iTilesId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iTilesId', 'iReportId', 'uid_no', 'thickness', 'size_of_tiles',
        'date_of_casting', 'date_of_testing', 'age_of_specimen',
        'load_1', 'load_2', 'load_3', 'comp_strength_1', 'comp_strength_2',
        'comp_strength_3', 'avg_comp_strength', 'create_date', 'set_count',
    ];
}
