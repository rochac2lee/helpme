<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'type',
        'name',
        'phone',
        'email',
        'plan',
        'additional_users',
        'additional_whats',
        'has_campaigns',
        'status'
    ];
}
