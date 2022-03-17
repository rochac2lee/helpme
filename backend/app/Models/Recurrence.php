<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurrence extends Model
{
    use HasFactory;

    protected $fillable = [
        'input_id',
        'output_id',
        'portion',
        'due_date',
        'payment_slip',
        'payment_voucher',
        'payment_status'
    ];
}
