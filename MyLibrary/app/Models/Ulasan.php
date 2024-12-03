<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasans';

    protected $fillable = [
        'peminjaman_id',
        'comentar',
        'rating',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Loan::class);
    }
}
