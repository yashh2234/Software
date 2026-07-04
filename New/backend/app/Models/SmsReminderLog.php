<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsReminderLog extends Model
{
    protected $table = 'sms_reminder_log';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'iClientId', 'sent_date', 'balance_amount', 'advance_amount', 'total_amount',
    ];

    protected $casts = [
        'sent_date' => 'datetime',
        'balance_amount' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Registration::class, 'iClientId', 'iClientId');
    }
}
