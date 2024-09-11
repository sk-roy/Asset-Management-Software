<?php

namespace App\Models;

use App\Models\Asset;
use App\Models\category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'datetime',
        'description',
        'charge',
        'active_mode',
        'map_location',
    ];
    

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}