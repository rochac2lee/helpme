<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesByClients extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'plan_id',
        'title',
        'description',
        'status',
        'aditionals_users',
        'api'
    ];
}
