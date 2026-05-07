<?php

namespace App\Services;

use App\Jobs\CacheCategoriesJob;
use Illuminate\Support\Facades\Cache;

class CategoryCacheService
{
    /**
     * Get all categories (from cache)
     */
    public static function getCategories()
    {
        $categories = Cache::get('post_categories');
        
        // Se não existir, dispara o job e retorna array vazio temporariamente
        if ($categories === null) {
            CacheCategoriesJob::dispatch();
            return [];
        }
        
        return $categories;
    }

    /**
     * Clear categories cache (when a new category is added)
     */
    public static function clearCategories()
    {
        Cache::forget('post_categories');
    }

    /**
     * Refresh categories cache immediately (sync)
     */
    public static function refreshCategories()
    {
        CacheCategoriesJob::dispatchSync();
    }

    /**
     * Check if cache exists
     */
    public static function hasCache(): bool
    {
        return Cache::has('post_categories');
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