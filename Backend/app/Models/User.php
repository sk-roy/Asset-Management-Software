<?php

namespace App\Models;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Document;
use App\Models\Note;
use App\Models\User;
use Laravel\Sanctum\HasAPITokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasAPITokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    public function assets()
    {
        return $this->hasMany(Asset::class);
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
    

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
