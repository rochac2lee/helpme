<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'initial_value',
        'inputs',
        'outputs',
        'description',
        'four_numbers_card'
    ];
}
