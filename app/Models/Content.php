<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }
}
