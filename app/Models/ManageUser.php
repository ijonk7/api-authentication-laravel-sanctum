<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'position',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}