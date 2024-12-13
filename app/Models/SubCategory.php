<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'metadata_id'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function metadata()
    {
        return $this->belongsTo(Metadata::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
