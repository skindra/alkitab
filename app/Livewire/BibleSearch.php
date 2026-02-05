<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\BibleVerse as Ayt;
use App\Models\Bookmark;


class BibleSearch extends Component
{
    public $search = '';
    public $results = [];
    public $visibleCount = 30;
    public $readingMode = false;
    public $bookmarks = [];
    public $darkMode = false;


    public function mount()
    {
        $this->bookmarks = Bookmark::pluck('ayt_id')->toArray();
    }


    public function updatedSearch()
    {
        $this->visibleCount = 30;
        $this->loadResults();
    }


    public function loadResults()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            return;
        }


        $this->results = Ayt::where('text', 'like', '%' . $this->search . '%')
            ->limit($this->visibleCount + 1)
            ->get();
    }


    public function loadMore()
    {
        $this->visibleCount += 30;
        $this->loadResults();
    }


    public function toggleBookmark($id)
    {
        if (in_array($id, $this->bookmarks)) {
            Bookmark::where('ayt_id', $id)->delete();
            $this->bookmarks = array_diff($this->bookmarks, [$id]);
        } else {
            Bookmark::create(['ayt_id' => $id]);
            $this->bookmarks[] = $id;
        }
    }


    public function toggleReadingMode()
    {
        $this->readingMode = !$this->readingMode;
    }


    public function render()
    {
        return view('livewire.bible-search');
    }

    public function toggleDark()
    {
        $this->darkMode = !$this->darkMode;
    }
}
