<?php
// app/Models/AboutDescription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutDescription extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];
}