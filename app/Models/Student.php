<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // 👇 THIS LIST TELLS LARAVEL: "IT IS SAFE TO SAVE THESE FIELDS"
    protected $fillable = [
        'user_id',      // <--- This was missing, causing the error!
        'first_name',
        'last_name',
        'phone',
        'city',
        'level'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
