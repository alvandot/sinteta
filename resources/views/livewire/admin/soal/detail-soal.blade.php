<div>
    <!-- Welcome Section -->
    <div
        class="p-6"
        x-data="{
            showAnimation: false,
            activeTab: 'info',
            isLoading: true,
            showFilter: false,
        }"
        x-init="
            setTimeout(() => (showAnimation = true), 500)
            setTimeout(() => (isLoading = false), 1000)
        "
    >
        <!-- Header Card -->
        <div
            class="mb-10"
            x-show="showAnimation"
            x-transition:enter="transition duration-1000 ease-out"
            x-transition:enter-start="-translate-y-12 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
        >
            <x-mary-card
                shadow
                class="transform overflow-hidden rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl"
            >
                <!-- Background Decorations -->
                <div
                    class="absolute end-0 top-0 -me-48 -mt-48 h-[500px] w-[500px] animate-pulse rounded-full bg-violet-500/20 blur-[100px]"
                ></div>
                <div
                    class="absolute bottom-0 start-0 -mb-48 -ms-48 h-[500px] w-[500px] animate-pulse rounded-full bg-indigo-500/20 blur-[100px]"
                ></div>

                <!-- Card Content -->
                <div class="relative p-12">
                    <div class="flex items-start justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <h2
                                    class="animate__animated animate__fadeInStart bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-6xl font-black tracking-tight text-transparent transition-transform duration-300 hover:scale-105"
                                >
                                    {{ $paketSoal->nama }}
                                </h2>
                                <span
                                    class="animate__animated animate__bounceIn animate__delay-1s cursor-pointer text-5xl transition-transform duration-300 hover:rotate-12"
                                >
                                    📚
                                </span>
                            </div>
                            <p
                                class="animate__animated animate__fadeInUp animate__delay-1s text-xl font-light tracking-wider text-gray-600 transition-colors duration-300 hover:text-indigo-600"
                            >
                                {{ $paketSoal->deskripsi }}
                            </p>
                            <div
                                class="animate__animated animate__fadeInUp animate__delay-2s flex gap-3"
                            >
                                <x-mary-button
                                    wire:click="$dispatch('showDaftarSoal')"
                                    icon="o-arrow-left"
                                    class="group border border-white/20 bg-gradient-to-br from-violet-500/40 to-indigo-500/40 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:scale-110 hover:from-violet-500/80 hover:to-indigo-500/80"
                                >
                                    Kembali
                                </x-mary-button>
                                <x-mary-button
                                    wire:click="edit"
                                    icon="o-pencil-square"
                                    class="group border border-white/20 bg-gradient-to-br from-yellow-500/40 to-orange-500/40 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:scale-110 hover:from-yellow-500/80 hover:to-orange-500/80"
                                >
                                    Edit
                                </x-mary-button>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex flex-col items-end space-y-2">
                            <span
                                @class([
                                    "rounded-full px-4 py-2 text-sm font-medium",
                                    "bg-green-100 text-green-700" => $statusPaket === "Aktif",
                                    "bg-yellow-100 text-yellow-700" => $statusPaket === "Belum Lengkap",
                                    "bg-gray-100 text-gray-700" => $statusPaket === "Draft",
                                ])
                            >
                                {{ $statusPaket }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Tingkat Kesulitan: {{ $tingkatKesulitan }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Waktu: {{ $waktuPengerjaan }} menit
                            </span>
                        </div>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Navigation Tabs -->
        <div
            class="mb-6 flex space-x-4 border-b"
            x-show="showAnimation"
            x-transition
        >
            <button
                @click="activeTab = 'info'"
                :class="{'border-b-2 border-violet-500 text-violet-600': activeTab === 'info'}"
                class="px-4 py-2 font-medium transition-colors hover:text-violet-600"
            >
                Informasi Umum
            </button>
            <button
                @click="activeTab = 'soal'"
                :class="{'border-b-2 border-violet-500 text-violet-600': activeTab === 'soal'}"
                class="px-4 py-2 font-medium transition-colors hover:text-violet-600"
            >
                Daftar Soal
            </button>
        </div>

        <!-- Stats Section -->
        <div
            x-show="activeTab === 'info'"
            x-transition:enter="transition duration-500 ease-out"
            x-transition:enter-start="-translate-y-4 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
        >
            <!-- Statistik Utama -->
            <div class="mb-8 grid w-full gap-12 lg:grid-cols-4">
                <x-mary-stat
                    label="Total Soal"
                    :value="$paketSoal->soals->count()"
                    icon="o-document-text"
                    class="group relative transform overflow-hidden rounded-[2rem] border-none bg-gradient-to-br from-violet-500/30 to-indigo-500/30 backdrop-blur-xl transition-all duration-700 hover:scale-105 hover:shadow-2xl hover:shadow-violet-500/30"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-violet-600/0 to-indigo-600/0 transition-all duration-700 group-hover:from-violet-600/20 group-hover:to-indigo-600/20"
                    ></div>
                    <div
                        class="absolute -bottom-8 -right-8 h-32 w-32 transform rounded-full bg-white/10 blur-2xl duration-700 group-hover:bg-violet-600/20"
                    ></div>
                </x-mary-stat>

                <x-mary-stat
                    label="Total Bobot"
                    :value="$totalBobot"
                    icon="o-scale"
                    class="group relative transform overflow-hidden rounded-[2rem] border-none bg-gradient-to-br from-fuchsia-500/30 to-pink-500/30 backdrop-blur-xl transition-all duration-700 hover:scale-105 hover:shadow-2xl hover:shadow-fuchsia-500/30"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-fuchsia-600/0 to-pink-600/0 transition-all duration-700 group-hover:from-fuchsia-600/20 group-hover:to-pink-600/20"
                    ></div>
                    <div
                        class="absolute -bottom-8 -right-8 h-32 w-32 transform rounded-full bg-white/10 blur-2xl duration-700 group-hover:bg-fuchsia-600/20"
                    ></div>
                </x-mary-stat>

                <x-mary-stat
                    label="Rata-rata Bobot"
                    :value="number_format($rataRataBobot, 1)"
                    icon="o-calculator"
                    class="group relative transform overflow-hidden rounded-[2rem] border-none bg-gradient-to-br from-cyan-500/30 to-blue-500/30 backdrop-blur-xl transition-all duration-700 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/30"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-cyan-600/0 to-blue-600/0 transition-all duration-700 group-hover:from-cyan-600/20 group-hover:to-blue-600/20"
                    ></div>
                    <div
                        class="absolute -bottom-8 -right-8 h-32 w-32 transform rounded-full bg-white/10 blur-2xl duration-700 group-hover:bg-cyan-600/20"
                    ></div>
                </x-mary-stat>
            </div>

            <!-- Informasi Detail -->
            <div class="mt-12 grid gap-8 lg:grid-cols-3">
                <!-- Informasi Paket Card -->
                <div class="lg:col-span-2">
                    <x-mary-card
                        title="Informasi Paket"
                        shadow
                        class="group relative overflow-hidden rounded-[2.5rem] border-none bg-gradient-to-br from-violet-50 via-indigo-50 to-purple-50 backdrop-blur-xl duration-500 hover:scale-[1.01] hover:shadow-2xl"
                    >
                        <!-- Animated Background Elements -->
                        <div
                            class="absolute right-0 top-0 h-64 w-64 animate-pulse rounded-full bg-violet-400/10 blur-3xl transition-all duration-700 group-hover:bg-violet-400/20"
                        ></div>
                        <div
                            class="absolute bottom-0 left-0 h-64 w-64 animate-pulse rounded-full bg-indigo-400/10 blur-3xl transition-all duration-700 group-hover:bg-indigo-400/20"
                        ></div>

                        <div class="relative z-10 grid grid-cols-2 gap-4">
                            <!-- Info Items -->
                            <div class="space-y-4">
                                <div
                                    class="transform rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                                >
                                    <p
                                        class="mb-1 text-sm font-medium text-gray-500"
                                    >
                                        Kode Paket
                                    </p>
                                    <p
                                        class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-lg font-bold text-transparent"
                                    >
                                        {{ $paketSoal->kode }}
                                    </p>
                                </div>

                                <div
                                    class="transform rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                                >
                                    <p
                                        class="mb-1 text-sm font-medium text-gray-500"
                                    >
                                        Kategori
                                    </p>
                                    <p
                                        class="bg-gradient-to-r from-fuchsia-600 to-pink-600 bg-clip-text text-lg font-bold text-transparent"
                                    >
                                        {{ $paketSoal->kategori }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div
                                    class="transform rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                                >
                                    <p
                                        class="mb-1 text-sm font-medium text-gray-500"
                                    >
                                        Tingkat Kesulitan
                                    </p>
                                    <p
                                        class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-lg font-bold text-transparent"
                                    >
                                        {{ $tingkatKesulitan }}
                                    </p>
                                </div>

                                <div
                                    class="transform rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                                >
                                    <p
                                        class="mb-1 text-sm font-medium text-gray-500"
                                    >
                                        Status
                                    </p>
                                    <span
                                        @class([
                                            "inline-block rounded-full px-4 py-1 text-sm font-semibold",
                                            "border border-green-200 bg-green-100 text-green-700" => $statusPaket === "Aktif",
                                            "border border-yellow-200 bg-yellow-100 text-yellow-700" => $statusPaket === "Belum Lengkap",
                                            "border border-gray-200 bg-gray-100 text-gray-700" => $statusPaket === "Draft",
                                        ])
                                    >
                                        {{ $statusPaket }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </x-mary-card>
                </div>

                <!-- Statistik Penggunaan Card -->
                <div class="lg:col-span-1">
                    <x-mary-card
                        title="Statistik Penggunaan"
                        shadow
                        class="group relative h-full overflow-hidden rounded-[2.5rem] border-none bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 backdrop-blur-xl duration-500 hover:scale-[1.01] hover:shadow-2xl"
                    >
                        <!-- Animated Background Elements -->
                        <div
                            class="absolute right-0 top-0 h-48 w-48 animate-pulse rounded-full bg-blue-400/10 blur-3xl transition-all duration-700 group-hover:bg-blue-400/20"
                        ></div>
                        <div
                            class="absolute bottom-0 left-0 h-48 w-48 animate-pulse rounded-full bg-cyan-400/10 blur-3xl transition-all duration-700 group-hover:bg-cyan-400/20"
                        ></div>

                        <div class="relative z-10 space-y-6">
                            <!-- Usage Stats -->
                            <div
                                class="flex transform items-center rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                            >
                                <i
                                    class="fas fa-chart-line mr-4 text-2xl text-blue-500"
                                ></i>
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Total Digunakan
                                    </p>
                                    <p class="text-lg font-bold text-blue-600">
                                        {{ $paketSoal->total_penggunaan ?? 0 }}
                                        kali
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex transform items-center rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                            >
                                <i
                                    class="fas fa-star mr-4 text-2xl text-cyan-500"
                                ></i>
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Rata-rata Nilai
                                    </p>
                                    <p class="text-lg font-bold text-cyan-600">
                                        {{ number_format($paketSoal->rata_rata_nilai ?? 0, 1) }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex transform items-center rounded-2xl bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white/80 hover:shadow-lg"
                            >
                                <i
                                    class="fas fa-clock mr-4 text-2xl text-teal-500"
                                ></i>
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Terakhir Digunakan
                                    </p>
                                    <p class="text-lg font-bold text-teal-600">
                                        {{ $paketSoal->terakhir_digunakan ? $paketSoal->terakhir_digunakan->diffForHumans() : "Belum pernah" }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </x-mary-card>
                </div>
            </div>
        </div>

        <!-- Daftar Soal Section -->
        <div
            x-show="activeTab === 'soal'"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        >
            <!-- Filter & Search -->
            <div class="mb-6 flex items-center justify-between">
                <div class="flex space-x-4">
                    <x-mary-button
                        @click="showFilter = !showFilter"
                        icon="o-funnel"
                        class="bg-violet-100 text-violet-700 hover:bg-violet-200"
                    >
                        Filter
                    </x-mary-button>
                    <div
                        x-show="showFilter"
                        class="absolute z-10 mt-12 rounded-lg border border-gray-100 bg-white p-4 shadow-xl"
                    >
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Jenis Soal
                                </label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                                >
                                    <option value="">Semua</option>
                                    <option value="pilihan_ganda">
                                        Pilihan Ganda
                                    </option>
                                    <option value="multiple_choice">
                                        Multiple Choice
                                    </option>
                                    <option value="essay">Essay</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-gray-700"
                                >
                                    Urutan
                                </label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500"
                                >
                                    <option value="asc">Terlama</option>
                                    <option value="desc">Terbaru</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Cari soal..."
                        class="rounded-lg border border-gray-300 py-2 pl-10 pr-4 focus:border-violet-500 focus:ring-violet-500"
                    />
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                    >
                        <svg
                            class="h-5 w-5 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @foreach ($paketSoal->soals as $soal)
                    <div
                        x-intersect:enter="$el.classList.add('opacity-100', 'translate-y-0')"
                        x-intersect:leave="$el.classList.remove('opacity-100', 'translate-y-0')"
                        class="translate-y-4 opacity-0 transition-all duration-500"
                    >
                        <x-mary-card
                            shadow
                            class="rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg duration-300 hover:scale-[1.01]"
                        >
                            <div class="space-y-6 p-8">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <h3
                                            class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-2xl font-black text-transparent"
                                        >
                                            Soal #{{ $soal->nomor_urut }}
                                        </h3>
                                        <span
                                            class="rounded-full px-3 py-1 text-xs font-medium"
                                            @class([
                                                "bg-blue-100 text-blue-700" => $soal->jenis_soal === "pilihan_ganda",
                                                "bg-purple-100 text-purple-700" => $soal->jenis_soal === "multiple_choice",
                                                "bg-green-100 text-green-700" => $soal->jenis_soal === "essay",
                                            ])
                                        >
                                            {{ ucfirst(str_replace("_", " ", $soal->jenis_soal)) }}
                                        </span>
                                    </div>
                                    <span
                                        class="rounded-full bg-violet-100 px-4 py-2 text-sm font-medium text-violet-700"
                                    >
                                        Bobot: {{ $soal->bobot }}
                                    </span>
                                </div>

                                <div class="prose max-w-none">
                                    {!! $soal->pertanyaan !!}
                                </div>

                                <!-- Opsi Jawaban -->
                                @if (in_array($soal->jenis_soal, ["pilihan_ganda", "multiple_choice"]))
                                    <div class="mt-4 space-y-4">
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <h4
                                                class="text-lg font-medium text-gray-700"
                                            >
                                                Opsi Jawaban:
                                            </h4>
                                            <div class="flex items-center">
                                                <span
                                                    class="mr-2 text-sm font-medium text-gray-600"
                                                >
                                                    Kunci:
                                                </span>

                                                @if ($soal->jenis_soal === "pilihan_ganda")
                                                    <span
                                                        class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700"
                                                    >
                                                        Opsi
                                                        {{ strtoupper($soal->kunci_pg) }}
                                                    </span>
                                                @else
                                                    <div class="flex space-x-2">
                                                        @foreach ((array) $soal->kunci_multiple_choice as $kunci)
                                                            <span
                                                                class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700"
                                                            >
                                                                Opsi
                                                                {{ strtoupper($kunci) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="grid gap-3">
                                            @foreach ($soal->soalOpsi as $opsi)
                                                <div
                                                    class="@if (

                                                        ($soal->jenis_soal === "pilihan_ganda" &&
                                                            $soal->kunci_pg === $opsi->urutan) ||
                                                        ($soal->jenis_soal === "multiple_choice" &&
                                                            in_array($opsi->urutan, (array) $soal->kunci_multiple_choice)))
                                                        bg-green-50
                                                        border
                                                        border-green-200
                                                    @else
                                                        bg-gray-50
                                                        border
                                                        border-gray-200
                                                    @endif flex items-start space-x-3 rounded-lg p-3"
                                                >
                                                    <div
                                                        class="mt-0.5 flex-shrink-0"
                                                    >
                                                        <span
                                                            class="@if (

                                                                ($soal->jenis_soal === "pilihan_ganda" &&
                                                                    $soal->kunci_pg === $opsi->urutan) ||
                                                                ($soal->jenis_soal === "multiple_choice" &&
                                                                    in_array($opsi->urutan, (array) $soal->kunci_multiple_choice)))
                                                                bg-green-200
                                                                text-green-700
                                                            @else
                                                                bg-gray-200
                                                                text-gray-700
                                                            @endif flex h-6 w-6 items-center justify-center rounded-full text-sm font-medium"
                                                        >
                                                            {{ strtoupper($opsi->urutan) }}
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div
                                                            class="prose prose-sm max-w-none"
                                                        >
                                                            {!! $opsi->teks !!}
                                                        </div>
                                                    </div>
                                                    @if (

                                                        ($soal->jenis_soal === "pilihan_ganda" &&
                                                            $soal->kunci_pg === $opsi->urutan) ||
                                                        ($soal->jenis_soal === "multiple_choice" &&
                                                            in_array($opsi->urutan, (array) $soal->kunci_multiple_choice))                                                    )
                                                        <div
                                                            class="flex-shrink-0"
                                                        >
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700"
                                                            >
                                                                <svg
                                                                    class="mr-1 h-3 w-3"
                                                                    fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                >
                                                                    <path
                                                                        fill-rule="evenodd"
                                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                        clip-rule="evenodd"
                                                                    />
                                                                </svg>
                                                                Jawaban Benar
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Kunci Jawaban Essay -->
                                @if ($soal->jenis_soal === "essay")
                                    <div class="mt-4">
                                        <h4
                                            class="mb-2 flex items-center text-lg font-medium text-gray-700"
                                        >
                                            <span>Kunci Jawaban</span>
                                            <span
                                                class="ml-2 rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800"
                                            >
                                                Rahasia
                                            </span>
                                        </h4>
                                        <div
                                            class="border-l-4 border-yellow-200 pl-4"
                                        >
                                            <div
                                                class="prose prose-sm max-w-none rounded-lg bg-gray-50 p-3"
                                            >
                                                {!! $soal->kunci_essay !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($soal->gambar)
                                    <div>
                                        <h4
                                            class="mb-4 text-lg font-medium text-gray-700"
                                        >
                                            Gambar Soal
                                        </h4>
                                        <img
                                            loading="lazy"
                                            src="{{ Storage::url($soal->gambar) }}"
                                            alt="Gambar Soal #{{ $soal->nomor_urut }}"
                                            class="cursor-zoom-in rounded-lg shadow-lg transition-transform duration-300 hover:scale-105"
                                            @click="$dispatch('open-modal', { image: '{{ Storage::url($soal->gambar) }}' })"
                                        />
                                    </div>
                                @endif

                                @if ($soal->audio)
                                    <div>
                                        <h4
                                            class="mb-4 text-lg font-medium text-gray-700"
                                        >
                                            Audio Soal
                                        </h4>
                                        <audio
                                            controls
                                            class="w-full"
                                            preload="none"
                                        >
                                            <source
                                                src="{{ Storage::url($soal->audio) }}"
                                                type="audio/mpeg"
                                            />
                                            Browser Anda tidak mendukung
                                            pemutaran audio.
                                        </audio>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex justify-end space-x-2 pt-4">
                                    <x-mary-button
                                        icon="o-eye"
                                        class="bg-violet-100 text-violet-700 hover:bg-violet-200"
                                    >
                                        Preview
                                    </x-mary-button>
                                    <x-mary-button
                                        wire:click="edit({{ $soal->id }})"
                                        icon="o-pencil-square"
                                        class="bg-blue-100 text-blue-700 hover:bg-blue-200"
                                    >
                                        Edit
                                    </x-mary-button>
                                </div>
                            </div>
                        </x-mary-card>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div
        x-data="{
            showModal: false,
            imageUrl: '',
        }"
        @open-modal.window="showModal = true; imageUrl = $event.detail.image"
        x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-transition
    >
        <div
            class="max-w-4xl rounded-lg bg-white p-4"
            @click.away="showModal = false"
        >
            <img
                :src="imageUrl"
                alt="Preview Gambar"
                class="h-auto w-full rounded-lg"
            />
            <div class="mt-4 flex items-center justify-between">
                <button
                    @click="showModal = false"
                    class="rounded-lg bg-violet-500 px-4 py-2 text-white transition-colors hover:bg-violet-600"
                >
                    Tutup
                </button>
                <a
                    :href="imageUrl"
                    download
                    class="rounded-lg bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600"
                >
                    Download
                </a>
            </div>
        </div>
    </div>
</div>
