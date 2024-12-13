<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;

    protected $fillable = ['fav_properties', 'name', 'email', 'properties_id'];
  
    public function property()
    {
        return $this->belongsTo(Property::class, 'properties_id');
    }
}

