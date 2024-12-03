<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = ['name'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }



}
