<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BibleBook extends Model
{
    // Nama Kitab
    protected $table = 'nama_kitab';
    protected $primaryKey = 'no';
    protected $guarded = [];

    public function ayat()
    {
        return $this->hasMany(BibleVerse::class, 'book', 'no');
    }
}
