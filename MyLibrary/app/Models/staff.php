<?php
// app/Models/Staff.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'no_telepon',
        'tanggal_bergabung',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
