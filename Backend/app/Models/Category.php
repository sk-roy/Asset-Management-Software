<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories';

    protected $fillable = [
        'name', 'title',
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }

}
