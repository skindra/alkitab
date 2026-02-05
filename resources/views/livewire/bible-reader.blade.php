<div class="{{ $darkMode ? 'dark' : '' }} min-h-screen bg-gray-100 text-gray-800 dark:bg-[#213448] dark:text-white">

    <!-- HEADER (FIXED) -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#1e3a5f] via-[#2d4a6f] to-[#1e3a5f] text-white shadow-lg">
        <div class="h-16 px-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <!-- Toggle Sidebar (Desktop) -->
                <button wire:click="$toggle('sidebarOpen')"
                    class="hidden md:inline-flex items-center justify-center w-9 h-9 rounded hover:bg-white/10 transition">
                    ☰
                </button>

                <!-- Toggle Drawer (Mobile) -->
                <button wire:click="$toggle('mobileMenu')"
                    class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded hover:bg-white/10 transition">
                    ☰
                </button>

                <div>
                    <h1 class="text-base font-semibold"><a href="/">📖 Alkitab Online</a></h1>
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
                <!-- Link Search -->
                <a href="{{ route('bible.search') }}"
                    class="px-3 py-1 rounded text-sm bg-[#213448]  hover:bg-gray-500 dark:hover:bg-white/30 transition">
                    Cari Ayat
                </a>
            </div>
        </div>
    </header>

    <!-- WRAPPER (OFFSET HEADER HEIGHT) -->
    <div class="pt-16 flex h-screen z-0">

        <!-- OVERLAY (MOBILE) -->
        @if ($mobileMenu)
            <div wire:click="$set('mobileMenu', false)" class="fixed inset-0 bg-black/40 z-40 md:hidden"></div>
        @endif

        <!-- SIDEBAR (DESKTOP COLLAPSIBLE + MOBILE DRAWER) -->
        <aside
            class="
                fixed md:static z-50 h-[calc(100vh-4rem)]
                bg-white dark:bg-[#1b2a3a]
                border-r border-gray-200 dark:border-white/10
                overflow-y-auto
                transform transition-all duration-300 ease-in-out
                {{ $mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0' }}
                {{ $sidebarOpen ? 'md:w-64' : 'md:w-16' }}
                w-64
            ">

            <div class="p-3">
                <h2
                    class="text-xs font-semibold uppercase tracking-wide mb-3 opacity-70 {{ $sidebarOpen ? '' : 'hidden md:block' }} dark:text-gray-400">
                    Daftar Kitab
                </h2>

                <ul class="space-y-1 text-sm dark:text-gray-300">
                    @foreach ($books as $book)
                        <li>
                            <button wire:click="selectBook({{ $book->no }})"
                                class="
                                    w-full flex items-center gap-2
                                    px-3 py-2 rounded
                                    hover:bg-gray-100 dark:hover:bg-white/10
                                    transition
                                ">
                                <span class="text-base">📘</span>
                                <span class="{{ $sidebarOpen ? 'inline' : 'hidden md:inline' }}">
                                    {{ $book->nama }}
                                </span>
                                </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- CONTENT -->
        <main
            class="
                flex-1
                ml-0 md:ml-0
                bg-gray-50 dark:bg-[#213448]
                overflow-y-auto
                transition-all duration-300
            ">
            <div class="p-6">

                <!-- SEARCH -->
                @if ($selectedBook)
                    <div class="mb-4">
                        <input type="text" wire:model.live="search" placeholder="Cari ayat..."
                            class="
                                w-full border border-gray-300 dark:border-white/20
                                rounded px-3 py-2 text-sm
                                bg-white dark:bg-[#1b2a3a]
                                text-gray-800 dark:text-white
                                placeholder-gray-400 dark:placeholder-gray-300
                                focus:outline-none focus:ring-2 focus:ring-white/30
                            ">
                    </div>
                @endif

                <!-- TITLE -->
                <h2 class="text-lg font-semibold mb-3 dark:text-gray-400">
                    {{ $selectedBook ? $selectedBook->nama : 'Pilih Kitab' }}
                </h2>
                @if ($search)
                    <div class="text-sm text-red-500 mb-3">
                        Search: {{ $search }} #{{ count($verses) }} hasil
                    </div>
                @endif

                <!-- VERSES LIST -->
                <!-- VERSES (LIST GROUP + BOOKMARK + SHARE + READING MODE + VIRTUAL SCROLL) -->
                <div class="space-y-3 {{ $readingMode ? 'text-base leading-loose' : 'text-sm leading-relaxed' }}">

                    @php
                        $displayed = collect($verses)->take($visibleCount);
                    @endphp

                    @forelse ($displayed as $i => $verse)
                        <div
                            class="
                group flex items-start gap-3
                p-4 rounded-xl
                bg-white dark:bg-[#1b2a3a]
                border border-gray-200 dark:border-white/10
                shadow-sm
                hover:shadow-md hover:-translate-y-[1px]
                transition-all duration-200
            ">
                            <!-- Nomor Ayat -->
                            <div
                                class="
                    flex-shrink-0
                    w-8 h-8
                    flex items-center justify-center
                    rounded-full
                    bg-[#213448] text-white
                    text-xs font-semibold
                ">
                                {{ $i + 1 }}
                                {{-- {{ $verse->id }} --}}
                            </div>

                            <!-- Konten -->
                            <div class="flex-1 text-gray-800 dark:text-gray-100">
                                <div class="flex items-center">
                                    <div>{{ $verse->text }}</div>
                                    <div
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center
                    rounded-full text-white font-semibold bg-[#3d75b1] m-2 text-xs">
                                        ({{ $verse->chapter }}:{{ $verse->verse }})
                                    </div>
                                </div>
                                <!-- Actions -->
                                <div class="mt-2 flex items-center gap-3 text-xs opacity-80">
                                    <!-- Bookmark -->
                                    <button wire:click="toggleBookmark({{ $verse->id }})"
                                        class="hover:opacity-100 transition" title="Bookmark">
                                        @if (in_array($verse->id, $bookmarks))
                                            ⭐ Favorit
                                        @else
                                            ☆ Simpan
                                        @endif
                                    </button>

                                    <!-- Share WhatsApp -->
                                    <a target="_blank" href="https://wa.me/?text={{ urlencode($verse->text) }}"
                                        class="hover:underline">
                                        📤 WhatsApp
                                    </a>

                                    <!-- Copy -->
                                    <button onclick="navigator.clipboard.writeText('{{ addslashes($verse->text) }}')"
                                        class="hover:underline" title="Copy">
                                        📋 Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="
                p-4 rounded-lg
                bg-white dark:bg-[#1b2a3a]
                border border-gray-200 dark:border-white/10
                text-center text-sm italic
                text-gray-500 dark:text-gray-300
            ">
                            Tidak ada ayat.
                        </div>
                    @endforelse

                    <!-- VIRTUAL SCROLL: LOAD MORE -->
                    @if (count($verses) > $visibleCount)
                        <div class="pt-2 text-center">
                            <button wire:click="loadMore"
                                class="px-4 py-2 text-sm rounded bg-gray-200 dark:bg-white/10 hover:bg-gray-300 dark:hover:bg-white/20 transition dark:text-white">
                                ⬇ Muat Lebih Banyak
                            </button>
                        </div>
                    @endif

                </div>

                {{-- End verses --}}



            </div>
        </main>

    </div>

    <footer class="text-center text-xs text-gray-500 dark:text-gray-300 py-4">
        © 2026 Alkitab Online
    </footer>

</div>
