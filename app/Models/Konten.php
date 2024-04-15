<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    protected static function boot()
    {
        parent::boot();
        //function dipakai, atur logika atau mendefinisikan nilai sebelum simpan data
        static::creating(function ($dt) {
            $dt->slug = generateSlug($dt->judul, $dt->waktu);
            $dt->user_id = getUserIdFromToken();
        });

        // static::updating(function ($dt) {
        //     $dt->user_id = getUserIdFromToken();
        // });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisKonten()
    {
        return $this->belongsTo(JenisKonten::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function publikasi()
    {
        return $this->hasOne(Publikasi::class);
    }

    public function likedislike()
    {
        return $this->hasMany(LikeDislike::class);
    }
}
