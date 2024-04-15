<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKonten extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    protected static function boot()
    {
        parent::boot();
        //function dipakai, atur logika atau mendefinisikan nilai sebelum simpan data
        static::creating(function ($dt) {
            $dt->user_id = getUserIdFromToken();
        });

        static::updating(function ($dt) {
            $dt->user_id = getUserIdFromToken();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function konten()
    {
        return $this->hasMany(Konten::class);
    }

    public function publikasi()
    {
        return $this->hasMany(Publikasi::class);
    }

    public function file()
    {
        return $this->hasMany(File::class);
    }
}
