<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'pages',
        'price',
        'isbn',
        'cover_image',
        'released_at',
        'in_stock',
        'deleted'
    ];

    protected $attributes = [
        'in_stock' => true,
        'deleted' => false,
    ];
    
    protected $casts = [
        'released_at' => 'datetime',
        'pages' => 'integer',
        'price' => 'float',
        'in_stock' => 'boolean',
        'deleted' => 'boolean',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
