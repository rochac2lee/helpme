<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputsSubcategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'output_category_id',
        'subcategory'
    ];
}
