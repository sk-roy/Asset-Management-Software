<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Note;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'address',
        'flat_number',
        'floor_number',
        'area',
        'purchase_price',
        'purchase_date',
        'diagram_path',
        'latitude',
        'longitude',
        'brand',
        'model',
        'capacity',   // litre for fridge, ton for AC, CC for vehicle etc.
        'specification',  // RAM, ROM size, etc.
        'plate_number',  // for vehicle
        'weight',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
}
