<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Tambahkan 'category_id' ke fillable
    protected $fillable = ['name', 'description', 'stock', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}