<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BibleBook;
use App\Models\BibleVerse;
use App\Models\Bookmark;

class BibleReader extends Component
{
    public $books;
    public $selectedBook = null;
    public $verses = [];
    public $search = '';
    public $darkMode = false;
    public $sidebarOpen = true;   // desktop collapse
    public $mobileMenu = false;   // mobile drawer
    public $readingMode = false;     // Mode baca
    public $visibleCount = 30;       // Virtual scroll (awal render)
    public $bookmarks = [];          // id ayat yang dibookmark
    public function mount()
    {
        $this->books = BibleBook::orderBy('no')->get();
        $this->bookmarks = Bookmark::pluck('ayt_id')->toArray();
    }

    public function selectBook($bookNo)
    {
        $this->selectedBook = BibleBook::where('no', $bookNo)->first();
        $this->loadVerses();
    }

    public function loadVerses()
    {
        $query = BibleVerse::where('book', $this->selectedBook->no);

        if ($this->search !== '') {
            $query->where('text', 'like', '%' . $this->search . '%');
        }

        $this->verses = $query->get();
    }

    public function updatedSearch()
    {
        if ($this->selectedBook) {
            $this->loadVerses();
        }
    }

    public function toggleDark()
    {
        $this->darkMode = !$this->darkMode;
    }

    public function render()
    {
        return view('livewire.bible-reader');
    }

    public function toggleBookmark($aytId)
    {
        if (in_array($aytId, $this->bookmarks)) {
            Bookmark::where('ayt_id', $aytId)->delete();
            $this->bookmarks = array_values(array_diff($this->bookmarks, [$aytId]));
        } else {
            Bookmark::create(['ayt_id' => $aytId]);
            $this->bookmarks[] = $aytId;
        }
    }
    public function toggleReadingMode()
    {
        $this->readingMode = !$this->readingMode;
    }

    public function loadMore()
    {
        $this->visibleCount += 30;
    }
}
