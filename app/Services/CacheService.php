<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Get all post categories (cached forever)
     */
    public static function getCategories()
    {
        return Cache::rememberForever('post_categories', function () {
            return Post::distinct('category')
                ->whereNotNull('category')
                ->pluck('category')
                ->filter()
                ->values();
        });
    }

    /**
     * Clear categories cache
     */
    public static function clearCategories()
    {
        Cache::forget('post_categories');
    }

    /**
     * Check if a category exists
     */
    public static function categoryExists($category)
    {
        return self::getCategories()->contains($category);
    }

    /**
     * Add a new category to cache (if not exists)
     */
    public static function addCategory($category)
    {
        $categories = self::getCategories();
        
        if (!$categories->contains($category)) {
            $categories->push($category);
            Cache::forever('post_categories', $categories);
        }
    }
}