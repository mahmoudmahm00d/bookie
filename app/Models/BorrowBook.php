<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'borrow_id',
        'price',
        'sale_price',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }
}
