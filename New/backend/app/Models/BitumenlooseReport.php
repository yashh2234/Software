<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitumenlooseReport extends Model
{
    protected $table = 'bitumenloose_report';
    protected $primaryKey = 'iBitumenLId';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iBitumenLId', 'iReportId', 'uid_no', 'name_of_test', 'grade_of_bitumen',
        'temp', 'penetration_value', 'avg_penetration_value', 'softening_point',
        'softening_point_avg', 'ductility_value', 'ductility_avg',
        'elastic_recovery', 'elastic_recovery_avg', 'viscosity_value',
        'viscosity_avg', 'create_date', 'set_count',
    ];
}
