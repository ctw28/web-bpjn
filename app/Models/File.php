<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function publikasi()
    {
        return $this->hasMany(Publikasi::class);
    }

    public function likedislike()
    {
        return $this->hasMany(LikeDislike::class);
    }
}
