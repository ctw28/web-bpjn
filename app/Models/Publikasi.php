<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    protected static function boot()
    {
        parent::boot();
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

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function konten()
    {
        return $this->belongsTo(Konten::class);
    }
}
