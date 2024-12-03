<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'dendas';

    protected $fillable = [
        'peminjaman_id',
        'jam_terlambat',
        'denda_total',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Loan::class);
    }
}
