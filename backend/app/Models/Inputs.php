<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inputs extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'description',
        'recurrence',
        'recurrence_lenght',
        'recurrence_type',
        'amount',
        'portion_amount',
        'due_date',
        'payment_status',
        'cat_input_id',
        'subcat_input_id',
        'account_id',
        'observation',
        'receipt_date'
    ];
}
