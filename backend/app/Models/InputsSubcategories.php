<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputsSubcategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'input_category_id',
        'subcategory'
    ];
}
