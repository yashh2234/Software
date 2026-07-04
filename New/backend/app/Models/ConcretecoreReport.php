<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcretecoreReport extends Model
{
    protected $table = 'concretecore_report';
    protected $primaryKey = 'iCoreId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iCoreId', 'iReportId', 'uid_no', 'location', 'depth_of_core',
        'dia_of_core', 'length_of_core', 'date_of_casting', 'date_of_testing',
        'age_of_specimen', 'load', 'comp_strength', 'avg_comp_strength',
        'is_code_comp_strength', 'set_count', 'create_date',
    ];
}
