<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Briefing extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'type',
        'name',
        'cnpj',
        'email',
        'phone',
        'socials',
        'adress',
        'projectDeadline',
        'hasLogo',
        'comments',
        'hasIntegration',

        /** Campos do briefing do app */
        'companyServices',
        'appFunctions',
        'appRefer',

        /** Campos do briefing do site */
        'home',
        'about',
        'contact',
        'services',
        'competitors',
        'colors',
        'colorsDont',
        'appearance',
        'siteRefer',
        'copywriting',

        /** Campos do briefing do sistema */
        'companyDescription',
        'whySystem',
        'hasSystem',
        'currentSystemFunction',

        'status'
    ];
}
