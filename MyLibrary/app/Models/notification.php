<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id', // ID mahasiswa yang menerima notifikasi
        'loan_id',
        'message',      // Isi pesan notifikasi
        'is_read'     // Status apakah sudah dibaca
    ];

    /**
     * Relasi dengan model Mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class); // Asumsi mahasiswa disimpan di tabel users
    }
    public function Loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
