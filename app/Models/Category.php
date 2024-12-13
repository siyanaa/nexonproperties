<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'metadata_id'
    ];

    // Relationships
    public function metadata()
    {
        return $this->belongsTo(Metadata::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
