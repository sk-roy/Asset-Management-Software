<?php

namespace App\Models;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'datetime',
        'description',
        'charge',
        'active_mode',
        'map_location',
        'service_provider',
        'service_details',   
        'cleaning_service',  
        'cleaning_charge',  
        'replacement_item',
        'replacement_cost',
        'visitor_name', 
        'visit_purpose', 
        'bill_provider',  
        'bill_amount',        
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}