<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';

    protected $fillable = [
        'name',
        'email',
        'message',
        'inspection',
        'properties_id'
    ];

    public function property()
{
    return $this->belongsTo(Property::class, 'properties_id');
}
}
