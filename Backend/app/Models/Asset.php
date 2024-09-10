<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Note;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
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
    
}
