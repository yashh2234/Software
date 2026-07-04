<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table = 'billing';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'uid_no', 'bill_no', 'bill_amount', 'advance_amount', 'mode_of_payment',
        'amount_received', 'amount_received_date', 'due_amount', 'discount',
        'payment_followup', 'remark',
    ];

    protected $casts = [
        'bill_amount' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'amount_received' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'amount_received_date' => 'date',
        'created_date' => 'datetime',
    ];
}
