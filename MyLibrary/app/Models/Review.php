<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'loan_id',
        'comment',
        'rating',
    ];

    public function Loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
