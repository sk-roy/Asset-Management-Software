<?php

namespace App\Models;

use App\Model\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name', 'path', 'mime_type', 'size',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
