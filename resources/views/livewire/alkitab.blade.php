<div class="{{ $darkMode ? 'dark' : '' }} min-h-screen">

    <!-- Header -->
    <header class="bg-primary text-white p-4 flex justify-between items-center shadow">
        <div>
            <h1 class="text-lg font-semibold">📖 Alkitab</h1>
            <p class="text-xs opacity-80">Minimalis & Modern</p>
        </div>
        <button wire:click="toggleDark" class="bg-white/20 px-3 py-1 rounded text-sm hover:bg-white/30 transition">
            🌙 Dark
        </button>
    </header>

    <div class="container mx-auto p-4 grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- Sidebar Kitab -->
        <aside class="bg-white dark:bg-primary/90 rounded-lg shadow p-4">
            <h2 class="text-sm font-semibold mb-3 uppercase tracking-wide">Daftar Kitab</h2>
            <ul class="space-y-2 text-sm">
                @foreach ($books as $book)
                    <li>
                        <button wire:click="selectBook({{ $book->id }})"
                            class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-white/10">
                            {{ $book->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Content -->
        <main class="md:col-span-3 bg-white dark:bg-primary/90 rounded-lg shadow p-4">

            <!-- Controls -->
            @if ($selectedBook)
                <div class="flex flex-col md:flex-row gap-3 mb-4">

                    <!-- Pilih Pasal -->
                    <select wire:model="selectedChapter" wire:change="loadVerses"
                        class="border rounded px-3 py-2 text-sm dark:bg-primary dark:border-white/20">
                        @foreach ($chapters as $ch)
                            <option value="{{ $ch }}">Pasal {{ $ch }}</option>
                        @endforeach
                    </select>

                    <!-- Search -->
                    <input type="text" wire:model.debounce.300ms="search" placeholder="Cari ayat..."
                        class="border rounded px-3 py-2 text-sm flex-1 dark:bg-primary dark:border-white/20">
                </div>
            @endif

            <!-- Title -->
            <h2 class="text-lg font-semibold mb-3">
                {{ $selectedBook ? $selectedBook->name . ' - Pasal ' . $selectedChapter : 'Pilih Kitab' }}
            </h2>

            <!-- Verses -->
            <div class="space-y-2 text-sm leading-relaxed">
                @forelse ($verses as $verse)
                    <p><span class="font-semibold">{{ $verse->verse }}</span> {{ $verse->content }}</p>
                @empty
                    <p class="italic opacity-70">Tidak ada ayat.</p>
                @endforelse
            </div>

        </main>
    </div>

    <footer class="text-center text-xs text-gray-500 dark:text-gray-300 py-4">
        © 2026 Alkitab Online
    </footer>
</div>
