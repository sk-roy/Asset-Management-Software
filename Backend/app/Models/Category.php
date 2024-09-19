<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Asset;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories';

    protected $fillable = [
        'name', 
        'title', 
        'type',
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class, 'category_field');
    }

}
