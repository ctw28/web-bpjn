<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKonten extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

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
