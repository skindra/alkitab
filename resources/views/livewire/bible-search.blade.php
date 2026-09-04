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
            <div class="flex items-center gap-2">
                <!-- Dark Mode -->
                <button wire:click="toggleDark" aria-label="Ganti mode gelap"
                    class="flex items-center justify-center w-11 h-11 rounded text-sm bg-white/20 hover:bg-white/30 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="w-5 h-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>
                <!-- Mode Baca -->
                <button wire:click="toggleReadingMode"
                    class="flex items-center gap-1 px-3 py-2 rounded text-sm bg-[#213448] hover:bg-gray-500 dark:hover:bg-white/30 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="w-4 h-4" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Mode Baca
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
                class="w-full max-w-3xl mx-auto mb-5 px-4 py-2 rounded-lg text-sm
bg-white dark:bg-[#1b2a3a]
border border-gray-300 dark:border-white/10
text-gray-800 dark:text-white
focus:outline-none focus:ring-2 focus:ring-primary">


            <!-- Results -->
            <div class="max-w-3xl mx-auto space-y-3 {{ $readingMode ? 'text-base leading-loose' : 'text-sm leading-relaxed' }}">
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
                        <div class="mt-2 flex gap-3 text-xs opacity-80">
                            <button wire:click="toggleBookmark({{ $verse->id }})"
                                aria-label="{{ in_array($verse->id, $bookmarks) ? 'Hapus dari favorit' : 'Simpan sebagai favorit' }}"
                                class="flex items-center gap-1 min-h-[44px] hover:opacity-100 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="{{ in_array($verse->id, $bookmarks) ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" stroke-width="1.5" class="w-4 h-4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 21.5a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                                {{ in_array($verse->id, $bookmarks) ? 'Favorit' : 'Simpan' }}
                            </button>

                            <a target="_blank" href="https://wa.me/?text={{ urlencode($verse->text) }}"
                                class="flex items-center gap-1 min-h-[44px] hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" class="w-4 h-4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.874L5.999 12zm0 0h7.5" />
                                </svg>
                                WhatsApp
                            </a>

                            <button onclick="navigator.clipboard.writeText('{{ addslashes($verse->text) }}')"
                                aria-label="Salin ayat"
                                class="flex items-center gap-1 min-h-[44px] hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" class="w-4 h-4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                                Copy
                            </button>
                        </div>
                    </div>
                @endforeach


                @if (count($results) > $visibleCount)
                    <div class="text-center pt-4">
                        <button wire:click="loadMore"
                            class="inline-flex items-center gap-1 px-4 py-2 text-sm rounded bg-gray-200 dark:bg-white/10 hover:bg-gray-300 dark:hover:bg-white/20 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5" class="w-4 h-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                            Muat Lebih Banyak
                        </button>
                    </div>
                @endif


            </div>
        </main>
    </div>
</div>
