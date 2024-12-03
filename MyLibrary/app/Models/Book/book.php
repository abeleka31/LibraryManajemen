<?php

namespace App\Models\Book;

use App\Models\Loan;
use App\Models\Review;
use App\Models\Ulasan;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Nama tabel, jika Anda tidak ingin menggunakan konvensi default
    protected $table = 'books';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name', 'image', 'penulis', 'penerbit', 'tahunTerbit', 'denda', 'status', 'ISBN', 'description', 'subcategory_id',  'jumlahStock',
    ];


    public function setJumlahStockAttribute($value)
    {
        $this->attributes['jumlahStock'] = $value;

        // Update status berdasarkan jumlah stok
        $this->attributes['status'] = $value > 0 ? 'tersedia' : 'tidak tersedia';
    }

    // Relasi dengan SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function category()
    {
        return $this->hasOneThrough(Category::class, SubCategory::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Loan::class);
    }

    public function averageRating()
    {
        return $this->hasManyThrough(Review::class, Loan::class)
                    ->avg('rating');
    }

}
