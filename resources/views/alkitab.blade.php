<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Alkitab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/logo.png" type="image/png">

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-primary dark:text-gray-100 transition">

    <!-- Header -->
    <header class="bg-primary text-white p-4 shadow flex justify-between items-center">
        <div>
            <h1 class="text-lg font-semibold flex items-center gap-2"><img src="/logo.png" alt="Alkitab" class="w-6 h-6"> Alkitab</h1>
            <p class="text-xs opacity-80">Minimalis & Modern</p>
        </div>
        <button onclick="toggleDarkMode()" class="bg-white/20 px-3 py-1 rounded text-sm hover:bg-white/30 transition">
            🌙 Dark
        </button>
    </header>

    <!-- Main -->
    <div class="container mx-auto p-4 grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- Sidebar Kitab -->
        <aside class="bg-white dark:bg-primary/90 rounded-lg shadow p-4">
            <h2 class="text-sm font-semibold mb-3 uppercase tracking-wide">Daftar Kitab</h2>
            <ul class="space-y-2 text-sm">
                <li><button onclick="loadBook('kejadian')"
                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-white/10">Kejadian</button>
                </li>
                <li><button onclick="loadBook('mazmur')"
                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-white/10">Mazmur</button>
                </li>
                <li><button onclick="loadBook('matius')"
                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-white/10">Matius</button>
                </li>
            </ul>
        </aside>

        <!-- Content -->
        <main class="md:col-span-3 bg-white dark:bg-primary/90 rounded-lg shadow p-4">

            <!-- Controls -->
            <div class="flex flex-col md:flex-row gap-3 mb-4">

                <!-- Pilih Pasal -->
                <select id="chapterSelect" onchange="loadChapter()"
                    class="border rounded px-3 py-2 text-sm dark:bg-primary dark:border-white/20">
                </select>

                <!-- Search Ayat -->
                <input type="text" id="searchInput" onkeyup="searchVerse()" placeholder="Cari ayat..."
                    class="border rounded px-3 py-2 text-sm flex-1 dark:bg-primary dark:border-white/20">

            </div>

            <!-- Title -->
            <h2 id="bookTitle" class="text-lg font-semibold mb-3">Pilih Kitab</h2>

            <!-- Content -->
            <div id="bookContent" class="space-y-2 text-sm leading-relaxed">
                <p>Silakan pilih kitab, pasal, atau cari ayat.</p>
            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer class="text-center text-xs text-gray-500 dark:text-gray-300 py-4">
        © 2026 Alkitab
    </footer>

    <!-- Script -->
    <script>
        const bibleData = {
            kejadian: {
                name: "Kejadian",
                chapters: {
                    1: [
                        "1 Pada mulanya Allah menciptakan langit dan bumi.",
                        "2 Bumi belum berbentuk dan kosong; gelap gulita menutupi samudera raya...",
                        "3 Berfirmanlah Allah: \"Jadilah terang.\" Lalu terang itu jadi."
                    ],
                    2: [
                        "1 Demikianlah diselesaikan langit dan bumi...",
                        "2 Pada hari ketujuh Allah telah menyelesaikan pekerjaan-Nya..."
                    ]
                }
            },
            mazmur: {
                name: "Mazmur",
                chapters: {
                    23: [
                        "1 TUHAN adalah gembalaku, takkan kekurangan aku.",
                        "2 Ia membaringkan aku di padang yang berumput hijau...",
                        "3 Ia menyegarkan jiwaku..."
                    ]
                }
            },
            matius: {
                name: "Matius",
                chapters: {
                    5: [
                        "1 Ketika Yesus melihat orang banyak itu, naiklah Ia ke atas bukit...",
                        "2 Maka Ia pun membuka mulut-Nya dan mengajar mereka...",
                        "3 \"Berbahagialah orang yang miskin di hadapan Allah...\""
                    ]
                }
            }
        };

        let currentBook = null;
        let currentChapter = null;

        function loadBook(bookKey) {
            currentBook = bibleData[bookKey];
            const chapterSelect = document.getElementById("chapterSelect");
            chapterSelect.innerHTML = "";

            Object.keys(currentBook.chapters).forEach(ch => {
                const option = document.createElement("option");
                option.value = ch;
                option.text = "Pasal " + ch;
                chapterSelect.appendChild(option);
            });

            currentChapter = Object.keys(currentBook.chapters)[0];
            loadChapter();
        }

        function loadChapter() {
            const chapterSelect = document.getElementById("chapterSelect");
            currentChapter = chapterSelect.value;

            const verses = currentBook.chapters[currentChapter];
            document.getElementById("bookTitle").innerText = currentBook.name + " - Pasal " + currentChapter;

            renderVerses(verses);
        }

        function renderVerses(verses) {
            let html = "";
            verses.forEach(v => {
                html += `<p>${v}</p>`;
            });
            document.getElementById("bookContent").innerHTML = html;
        }

        function searchVerse() {
            const keyword = document.getElementById("searchInput").value.toLowerCase();
            if (!currentBook) return;

            let results = [];

            Object.values(currentBook.chapters).forEach(chapter => {
                chapter.forEach(verse => {
                    if (verse.toLowerCase().includes(keyword)) {
                        results.push(verse);
                    }
                });
            });

            if (keyword === "") {
                loadChapter();
            } else if (results.length > 0) {
                renderVerses(results);
            } else {
                document.getElementById("bookContent").innerHTML = "<p class='italic opacity-70'>Ayat tidak ditemukan.</p>";
            }
        }

        function toggleDarkMode() {
            document.documentElement.classList.toggle("dark");
        }
    </script>

</body>

</html>
