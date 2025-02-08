<div
    class="animate-gradient-slow min-h-screen rounded-3xl bg-gradient-to-br from-white via-indigo-100 to-sky-100"
>
    <div class="max-w-8xl mx-auto px-6 py-10">
        <!-- Breadcrumb -->
        <nav
            class="mb-8 flex"
            x-data="{ isVisible: false }"
            x-init="
                setTimeout(() => (isVisible = true), 500)
                $watch('isVisible', (value) => {
                    if (value) {
                        $el.classList.add('opacity-100', 'translate-y-0')
                        $el.classList.remove('opacity-0', '-translate-y-4')
                    }
                })
            "
            :class="{ 'opacity-0 -translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
            class="transition-all duration-700 ease-out"
            aria-label="Breadcrumb"
        >
            <ol
                class="group inline-flex items-center space-x-1 rounded-3xl border border-white/30 bg-gradient-to-br from-white/80 via-white/60 to-transparent p-4 backdrop-blur-xl transition-all duration-500 hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] md:space-x-3"
                x-data="{ isHovered: false }"
                @mouseenter="isHovered = true"
                @mouseleave="isHovered = false"
                :class="{ 'scale-[1.02] shadow-2xl': isHovered }"
            >
                <li class="inline-flex items-center">
                    <a
                        href="/siswa"
                        class="group inline-flex items-center text-sm font-medium text-gray-700 transition-all duration-300 hover:text-violet-600"
                        x-data="{ pulse: false }"
                        @mouseenter="pulse = true"
                        @mouseleave="pulse = false; setTimeout(() => pulse = false, 300)"
                        :class="{ 'scale-110': pulse }"
                    >
                        <x-mary-icon
                            name="o-home"
                            class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12"
                        />
                        <span
                            class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text font-semibold hover:text-transparent"
                        >
                            Home
                        </span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-mary-icon
                            name="o-chevron-right"
                            class="h-4 w-4 animate-pulse text-violet-400"
                        />
                        <span
                            class="ml-1 bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-sm font-bold text-transparent md:ml-2"
                            x-data="{ hover: false }"
                            @mouseenter="hover = true"
                            @mouseleave="hover = false"
                            :class="{ 'scale-105': hover }"
                            style="transition: all 0.3s ease"
                        >
                            Dashboard
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="relative mb-16 text-center">
            <h1
                class="bg-gradient-to-r from-violet-600 via-fuchsia-600 to-pink-600 bg-clip-text font-black tracking-tight text-transparent drop-shadow-2xl sm:text-4xl lg:text-7xl"
            >
                Dashboard Siswa
            </h1>
            <p class="mt-4 text-2xl font-medium text-gray-600/80">
                Selamat datang di sistem CBT
            </p>
            <div
                class="absolute -bottom-4 left-1/2 h-2 w-32 -translate-x-1/2 transform rounded-full bg-gradient-to-r from-violet-500 via-fuchsia-500 to-pink-500 blur-sm"
            ></div>
        </div>

        <!-- Widget Jam dan Hari -->
        <div class="mb-8 flex items-center justify-center gap-8">
            <div
                class="rounded-2xl border border-white/20 bg-white/30 p-6 text-center shadow-lg backdrop-blur-sm"
            >
                <div
                    class="text-4xl font-bold text-gray-800"
                    x-data="clock()"
                    x-init="startClock()"
                    x-text="time"
                >
                    00:00:00
                </div>
                <div class="mt-2 text-lg font-medium text-gray-600">
                    {{ \Carbon\Carbon::now()->locale("id")->isoFormat("dddd") }}
                </div>
            </div>
            <div
                class="rounded-2xl border border-white/20 bg-white/30 p-6 text-center shadow-lg backdrop-blur-sm"
            >
                <div class="text-4xl font-bold text-gray-800">
                    {{ \Carbon\Carbon::now()->locale("id")->isoFormat("D MMMM Y") }}
                </div>
                <div class="mt-2 text-lg font-medium text-gray-600">
                    Kalender Akademik
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Jadwal Belajar -->
            <div
                class="group relative flex-1 overflow-hidden rounded-3xl border border-white/30 bg-white/20 shadow-xl backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-teal-200/50"
                style="
                    clip-path: polygon(
                        0% 0%,
                        100% 0%,
                        100% 95%,
                        95% 100%,
                        0% 100%
                    );
                "
            >
                <div
                    class="absolute inset-0 bg-gradient-to-br from-teal-50/30 via-cyan-50/30 to-sky-50/30 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                ></div>

                <!-- Wave Animation Top -->
                <div class="absolute left-0 top-0 h-16 w-full opacity-20">
                    <svg
                        class="h-full w-full"
                        viewBox="0 0 1440 320"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill="#0891b2"
                            fill-opacity="1"
                            d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,165.3C672,160,768,96,864,90.7C960,85,1056,139,1152,154.7C1248,171,1344,149,1392,138.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"
                        ></path>
                    </svg>
                </div>

                <div class="relative p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <h2
                            class="bg-gradient-to-r from-teal-700 to-cyan-700 bg-clip-text text-2xl font-bold text-transparent"
                        >
                            Jadwal Belajar
                        </h2>
                        <x-mary-icon
                            name="o-academic-cap"
                            class="h-8 w-8 text-teal-500"
                        />
                    </div>

                    <div class="space-y-4">
                        @foreach ($jadwalBelajars as $jadwal)
                            <div
                                class="rounded-lg border border-teal-100/50 bg-white/50 p-4 transition-all duration-300 hover:shadow-lg"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3
                                            class="text-lg font-semibold text-teal-800"
                                        >
                                            {{ $jadwal["nama_jadwal"] }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $jadwal["hari"] }} -
                                            {{ $jadwal["jam_mulai"] }} -
                                            {{ $jadwal["jam_selesai"] }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Ruangan: {{ $jadwal["ruangan"] }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Tentor: {{ $jadwal["tentor"] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Wave Animation Bottom -->
                <div class="absolute bottom-0 left-0 h-16 w-full opacity-20">
                    <svg
                        class="h-full w-full"
                        viewBox="0 0 1440 320"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill="#0891b2"
                            fill-opacity="1"
                            d="M0,64L48,80C96,96,192,128,288,122.7C384,117,480,75,576,80C672,85,768,139,864,144C960,149,1056,107,1152,90.7C1248,75,1344,85,1392,90.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                        ></path>
                    </svg>
                </div>
            </div>

            <!-- Jadwal Ujian -->
            <div
                class="group relative flex-1 overflow-hidden rounded-3xl border border-white/30 bg-white/20 shadow-xl backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-rose-200/50"
                style="
                    clip-path: polygon(
                        0% 0%,
                        100% 0%,
                        100% 95%,
                        95% 100%,
                        0% 100%
                    );
                "
            >
                <div
                    class="absolute inset-0 bg-gradient-to-br from-rose-50/30 via-pink-50/30 to-fuchsia-50/30 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                ></div>

                <!-- Wave Animation Top -->
                <div class="absolute left-0 top-0 h-16 w-full opacity-20">
                    <svg
                        class="h-full w-full"
                        viewBox="0 0 1440 320"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill="#e11d48"
                            fill-opacity="1"
                            d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,165.3C672,160,768,96,864,90.7C960,85,1056,139,1152,154.7C1248,171,1344,149,1392,138.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"
                        ></path>
                    </svg>
                </div>

                <div class="relative p-8">
                    <div class="mb-8 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="rounded-xl bg-rose-100 p-3">
                                <x-mary-icon
                                    name="o-pencil-square"
                                    class="h-8 w-8 text-rose-500"
                                />
                            </div>
                            <div>
                                <h2
                                    class="bg-gradient-to-r from-rose-700 to-pink-700 bg-clip-text text-2xl font-bold text-transparent"
                                >
                                    Jadwal Ujian
                                </h2>
                                <p class="text-sm text-gray-500">
                                    Persiapkan dirimu untuk ujian!
                                </p>
                            </div>
                        </div>
                        <span
                            class="rounded-full bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-600"
                        >
                            {{ count($ujians) }} Jadwal
                        </span>
                    </div>

                    <div class="space-y-4">
                        @foreach ($ujians as $ujian)
                            <div
                                class="rounded-lg border border-rose-100/50 bg-white/50 p-4 transition-all duration-300 hover:shadow-lg"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3
                                            class="text-lg font-semibold text-rose-800"
                                        >
                                            {{ $ujian["nama_ujian"] }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $ujian["tanggal"] }}
                                            {{ $ujian["waktu_mulai"] }} -
                                            {{ $ujian["waktu_selesai"] }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Mata Pelajaran:
                                            {{ $ujian["mata_pelajaran"] }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Ruangan: {{ $ujian["ruangan"] }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="rounded-full bg-rose-100 px-3 py-1 text-sm font-medium text-rose-700"
                                        >
                                            {{ $ujian["status"] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Wave Animation Bottom -->
                <div class="absolute bottom-0 left-0 h-16 w-full opacity-20">
                    <svg
                        class="h-full w-full"
                        viewBox="0 0 1440 320"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill="#e11d48"
                            fill-opacity="1"
                            d="M0,64L48,80C96,96,192,128,288,122.7C384,117,480,75,576,80C672,85,768,139,864,144C960,149,1056,107,1152,90.7C1248,75,1344,85,1392,90.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                        ></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Library Widget -->
        <div class="mt-8">
            <div
                class="group relative flex-1 overflow-hidden rounded-3xl border border-white/30 bg-white/20 shadow-xl backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-indigo-200/50"
                style="
                    clip-path: polygon(
                        0% 0%,
                        100% 0%,
                        100% 95%,
                        95% 100%,
                        0% 100%
                    );
                "
            >
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-50/30 via-purple-50/30 to-violet-50/30 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                ></div>

                <div class="relative p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="rounded-xl bg-indigo-100 p-3">
                                <x-mary-icon
                                    name="o-book-open"
                                    class="h-8 w-8 text-indigo-500"
                                />
                            </div>
                            <div>
                                <h2
                                    class="bg-gradient-to-r from-indigo-700 to-purple-700 bg-clip-text text-2xl font-bold text-transparent"
                                >
                                    Perpustakaan Digital
                                </h2>
                                <p class="text-sm text-gray-500">
                                    Akses materi pembelajaran kapan saja
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
                    >
                        <!-- Example Library Items -->
                        <div
                            class="rounded-lg border border-indigo-100/50 bg-white/50 p-4 transition-all duration-300 hover:shadow-lg"
                        >
                            <div class="flex items-start gap-4">
                                <div class="rounded-lg bg-indigo-100 p-2">
                                    <x-mary-icon
                                        name="o-document-text"
                                        class="h-6 w-6 text-indigo-500"
                                    />
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-indigo-800"
                                    >
                                        Modul Matematika
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Kelas X Semester 1
                                    </p>
                                    <button
                                        class="mt-2 rounded-full bg-indigo-600 px-3 py-1 text-sm font-medium text-white transition-colors hover:bg-indigo-700"
                                    >
                                        Unduh
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="rounded-lg border border-indigo-100/50 bg-white/50 p-4 transition-all duration-300 hover:shadow-lg"
                        >
                            <div class="flex items-start gap-4">
                                <div class="rounded-lg bg-indigo-100 p-2">
                                    <x-mary-icon
                                        name="o-video-camera"
                                        class="h-6 w-6 text-indigo-500"
                                    />
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-indigo-800"
                                    >
                                        Video Pembelajaran
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Fisika Dasar
                                    </p>
                                    <button
                                        class="mt-2 rounded-full bg-indigo-600 px-3 py-1 text-sm font-medium text-white transition-colors hover:bg-indigo-700"
                                    >
                                        Tonton
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="rounded-lg border border-indigo-100/50 bg-white/50 p-4 transition-all duration-300 hover:shadow-lg"
                        >
                            <div class="flex items-start gap-4">
                                <div class="rounded-lg bg-indigo-100 p-2">
                                    <x-mary-icon
                                        name="o-puzzle-piece"
                                        class="h-6 w-6 text-indigo-500"
                                    />
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-indigo-800"
                                    >
                                        Latihan Soal
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Bank Soal Kimia
                                    </p>
                                    <button
                                        class="mt-2 rounded-full bg-indigo-600 px-3 py-1 text-sm font-medium text-white transition-colors hover:bg-indigo-700"
                                    >
                                        Mulai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function clock() {
        return {
            time: '00:00:00',
            startClock() {
                setInterval(() => {
                    this.time = new Date().toLocaleTimeString('id-ID');
                }, 1000);
            },
        };
    }
</script>
