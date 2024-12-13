<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'designation',
        'review',
        'rating',
        'image',
        'status'
    ];
    protected $casts = [
        'image' => 'array', // Handle multi-image upload as an array
    ];

}
