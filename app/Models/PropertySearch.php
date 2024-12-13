<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PropertySearch extends Model
{
    // The model uses the 'properties' table
    protected $table = 'properties';

    // Define relationships to use in scopes
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    /**
     * Scope for filtering by category type.
     */
    public function scopeCategoryType(Builder $query, $categoryType)
    {
        return $query->when($categoryType, function ($q) use ($categoryType) {
            $q->whereHas('category', function ($query) use ($categoryType) {
                $query->where('name', 'like', "%{$categoryType}%");
            });
        });
    }

    /**
     * Scope for filtering by sub-category.
     */
    public function scopeSubCategory(Builder $query, $subCategory)
    {
        return $query->when($subCategory, function ($q) use ($subCategory) {
            $q->whereHas('subCategory', function ($query) use ($subCategory) {
                $query->where('name', 'like', "%{$subCategory}%");
            });
        });
    }

    /**
     * Scope for filtering by location.
     */
    public function scopeLocation(Builder $query, $location)
    {
        return $query->when($location, function ($q) use ($location) {
            $q->where(function ($query) use ($location) {
                $query->where('street', 'like', "%{$location}%")
                      ->orWhere('suburb', 'like', "%{$location}%")
                      ->orWhere('state', 'like', "%{$location}%")
                      ->orWhere('post_code', 'like', "%{$location}%")
                      ->orWhere('country', 'like', "%{$location}%");
            });
        });
    }

    /**
     * Scope for filtering by price range.
     */
    public function scopePrice(Builder $query, $minPrice, $maxPrice)
    {
        return $query->when($minPrice || $maxPrice, function ($q) use ($minPrice, $maxPrice) {
            if ($minPrice && $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            } elseif ($minPrice) {
                $q->where('price', '>=', $minPrice);
            } elseif ($maxPrice) {
                $q->where('price', '<=', $maxPrice);
            }
        });
    }

    /**
     * Scope for filtering by number of bedrooms.
     */
    public function scopeBedroom(Builder $query, $bedroom)
    {
        return $query->when($bedroom, function ($q) use ($bedroom) {
            $q->where('bedrooms', $bedroom);
        });
    }

    /**
     * Apply all filters to the query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public static function applyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->categoryType($filters['category_type'] ?? null)
            ->subCategory($filters['sub_category'] ?? null)
            ->location($filters['location'] ?? null)
            ->price($filters['min_price'] ?? null, $filters['max_price'] ?? null)
            ->bedroom($filters['bedroom'] ?? null);
    }
}
