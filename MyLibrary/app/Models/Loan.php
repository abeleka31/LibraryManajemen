<?php
namespace App\Models;

use App\Models\Book\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'book_id',
        'staff_borrow_id',
        'staff_return_id',
        'denda',
        'status',
        'borrow_date',
        'required_date',
        'return_date',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke Staff (yang menyetujui peminjaman)
    public function staffBorrow()
    {
        return $this->belongsTo(Staff::class, 'staff_borrow_id');
    }

    // Relasi ke Staff (yang menyetujui pengembalian)
    public function staffReturn()
    {
        return $this->belongsTo(Staff::class, 'staff_return_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
}
