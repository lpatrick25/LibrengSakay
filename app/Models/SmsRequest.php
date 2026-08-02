<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsRequest extends Model
{
    use HasFactory;

    protected $table = 'sms_requests';

    protected $fillable = [
        'phone_number',
        'message',
        'status',
    ];
}
