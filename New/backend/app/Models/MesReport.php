<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesReport extends Model
{
    protected $table = 'mes_report';
    protected $primaryKey = 'iMesId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iMesId', 'iReportId', 'uid_no', 'mould_size', 'location',
        'date_of_casting', 'date_of_testing', 'age_of_specimen',
        'weight', 'avg_comp_strength_1', 'avg_comp_strength_2',
        'avg_comp_strength_3', 'create_date', 'set_count',
    ];
}
