<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BibleVerse extends Model
{

    protected $table = 'ayt';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function nama_buku()
    {
        return $this->belongsTo(BibleBook::class, 'book', 'no');
    }
}
