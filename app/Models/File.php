<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    protected static function boot()
    {
        parent::boot();
        //function dipakai, atur logika atau mendefinisikan nilai sebelum simpan data
        static::creating(function ($dt) {
            // $menu->user_id = Auth::id();
            $dt->user_id = 1;
        });
    }

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
