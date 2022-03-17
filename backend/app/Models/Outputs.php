<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outputs extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'recurrence',
        'recurrence_lenght',
        'recurrence_type',
        'amount',
        'portion_amount',
        'due_date',
        'payment_status',
        'cat_output_id',
        'subcat_output_id',
        'account_id',
        'observation',
        'receipt_date'
    ];
}
