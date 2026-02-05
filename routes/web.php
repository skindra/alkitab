<?php

use App\Models\BibleBook;
use App\Models\BibleVerse;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('alkitab');
// });

Route::get('/', \App\Livewire\BibleReader::class);
Route::get('/search-alkitab', \App\Livewire\BibleSearch::class)->name('bible.search');

Route::get('/test', function () {
    // dd(BibleBook::all());
    $buku = BibleVerse::where('verse', 2)->first();
    dd($buku->nama_buku->nama);
    // foreach ($buku->book as $verse) {
    //     echo $verse->book->no . " ) " . $verse->text . "<br>";
    // }
    foreach ($buku as $verse) {
        // $verse->book;
        // echo $verse->book->no . " ) " . $verse->text . "<br>";
        // echo "ok";
    }
});
