<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'title', 'type'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_field');
    }

}
