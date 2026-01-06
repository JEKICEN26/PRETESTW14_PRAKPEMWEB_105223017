<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description', 'stock'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}