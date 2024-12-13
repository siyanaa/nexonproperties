<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class ReviewAndRating extends Model
{
    use HasFactory;


    protected $table = 'reviewsandratings';
    protected $fillable = ['name', 'email', 'reviews','ratings','properties_id','status'];

    public function property()
    {
        return $this->belongsTo(Property::class, 'properties_id');
    }
}



