<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['featured_properties', 'offered_properties', 'properties_id'];

    public function property()
    {
        return $this->belongsTo(Property::class, 'properties_id');
    } 
}
