<div class="{{ $darkMode ? 'dark' : '' }} min-h-screen bg-gray-100 text-gray-800 dark:bg-[#213448] dark:text-white">


    <!-- Header -->
    <header
        class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#1e3a5f] via-[#2d4a6f] to-[#1e3a5f] text-white shadow-lg">
        <div class="h-16 px-4 flex items-center justify-between">
            <div class="flex items-center gap-2">

                <div>
                    <h1 class="text-base font-semibold"><a href="/" class="flex items-center gap-2"><img src="/logo.png" alt="Alkitab" class="w-6 h-6"> Alkitab</a></h1>
                    <p class="text-[11px] opacity-80">Minimalis & Modern</p>
                </div>
            </div>
            <div class="flex items-center gap-2 mb-4">
                <!-- Dark Mode -->
                <button wire:click="toggleDark"
                    class="px-3 py-1 rounded text-sm bg-white/20 hover:bg-white/30 transition">
                    🌙
                </button>
                <!-- Mode Baca -->
                <button wire:click="toggleReadingMode"
                    class="px-3 py-1 rounded text-sm bg-[#213448]  hover:bg-gray-500 dark:hover:bg-white/30 transition">
                    📖 Mode Baca
                </button>

            </div>
        </div>
    </header>

    <div class="pt-16 flex h-screen z-0">
        <main
            class="
                flex-1
                ml-0 md:ml-0
                bg-gray-50 dark:bg-[#213448]
                overflow-y-auto
                transition-all duration-300
            ">
            <!-- Input Search -->
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari ayat di seluruh Alkitab..."
                class="w-full mb-5 px-4 py-2 rounded-lg text-sm
bg-white dark:bg-[#1b2a3a]
border border-gray-300 dark:border-white/10
text-gray-800 dark:text-white">


            <!-- Results -->
            <div class="space-y-3 {{ $readingMode ? 'text-base leading-loose' : 'text-sm leading-relaxed' }}">
                @php
                    $displayed = collect($results)->take($visibleCount);
                @endphp

                @foreach ($displayed as $i => $verse)
                    <div
                        class="p-4 rounded-xl bg-white dark:bg-[#1b2a3a]
border border-gray-200 dark:border-white/10 shadow">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Kitab {{ $verse->book }} : {{ $verse->chapter ?? '-' }} : {{ $verse->verse ?? '-' }}
                        </div>


                        <div class="text-gray-800 dark:text-gray-100">
                            {{ $verse->text }}
                        </div>


                        <!-- Actions -->
                        <div class="mt-2 flex gap-3 text-xs">
                            <button wire:click="toggleBookmark({{ $verse->id }})">
                                {{ in_array($verse->id, $bookmarks) ? '⭐ Favorit' : '☆ Simpan' }}
                            </button>


                            <a target="_blank" href="https://wa.me/?text={{ urlencode($verse->text) }}">
                                📤 WhatsApp
                            </a>


                            <button onclick="navigator.clipboard.writeText('{{ addslashes($verse->text) }}')">
                                📋 Copy
                            </button>
                        </div>
                    </div>
                @endforeach


                @if (count($results) > $visibleCount)
                    <div class="text-center pt-4">
                        <button wire:click="loadMore" class="px-4 py-2 text-sm rounded bg-gray-200 dark:bg-white/10">
                            ⬇ Muat Lebih Banyak
                        </button>
                    </div>
                @endif


            </div>
        </main>
    </div>
</div>
