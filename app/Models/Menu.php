<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'route_name',
        'url',
        'icon',
        'sort_order',
        'is_active',
        'is_system',
        'opens_in_new_tab',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_system' => 'boolean',
        'opens_in_new_tab' => 'boolean',
    ];

    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }

    public function getUrlAttribute($value)
    {
       
        if ($this->route_name) {
            try {
                return route($this->route_name);
            } catch (\Exception $e) {
                
            }
        }
        
       
        if ($value) {
            return $value;
        }
        
       
        if ($this->page) {
            return route('pages.show', $this->page->slug);
        }
        
        return '#';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }
}
