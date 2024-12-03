<?php
namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    // Tambahkan kolom yang ingin Anda izinkan untuk mass assignment
    protected $fillable = [
        'name', // Nama sub kategori
        'category_id', // Kategori ID yang terkait
    ];

    // Relasi dengan kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi SubCategory ke Book
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
