<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author',
        'image',
        'status',
        'metadata_id'
    ];
    protected $casts = [
        'image' => 'array', // Handle multi-image upload as an array
    ];

    // Relationships
    public function metadata()
    { 
        return $this->belongsTo(Metadata::class);
    }

}
