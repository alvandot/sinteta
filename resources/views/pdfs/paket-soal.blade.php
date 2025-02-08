<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>{{ $paketSoal->nama }}</title>

        @livewireStyles
        @vite(["resources/css/app.css", "resources/js/app.js"])

        <style>
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 200px;
                opacity: 0.05;
                z-index: -1;
                color: var(--mary-primary);
                font-weight: bold;
                white-space: nowrap;
                pointer-events: none;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                text-transform: uppercase;
                letter-spacing: 0.5em;
                line-height: 1;
                text-align: center;
            }

            @page {
                margin: 0;
            }
        </style>
    </head>

    <body class="mary-bg-surface min-h-screen">
        <div class="watermark">SINTETA</div>

        <div class="mx-auto max-w-5xl px-6 py-12">
            <!-- Header -->
            <x-mary-card class="mb-12">
                <div class="mb-6 flex items-center justify-center gap-6">
                    <img
                        src="{{ public_path("images/logo.webp") }}"
                        alt="Logo"
                        class="h-28 w-28 rounded-2xl shadow-2xl"
                    />
                    <div class="text-center">
                        <h1 class="text-primary mb-3 text-5xl font-black">
                            SINTETA Learning Center
                        </h1>
                        <p
                            class="text-2xl font-medium tracking-wider text-gray-600"
                        >
                            Bank Soal CBT SINTETA
                        </p>
                    </div>
                </div>
                <div
                    class="my-4 h-px w-full bg-gray-200 dark:bg-gray-700"
                ></div>
            </x-mary-card>

            <!-- Info Section -->
            <x-mary-card class="mb-12">
                <div class="grid grid-cols-2 gap-6">
                    <x-mary-stat
                        title="Mata Pelajaran"
                        value="{{ $paketSoal->mataPelajaran->nama_pelajaran }}"
                        icon="o-book-open"
                        color="primary"
                    />
                    <x-mary-stat
                        title="Tingkat"
                        value="Kelas {{ $paketSoal->tingkat }}"
                        icon="o-academic-cap"
                        color="secondary"
                    />
                    <x-mary-stat
                        title="Tahun"
                        value="{{ $paketSoal->tahun }}"
                        icon="o-calendar"
                        color="warning"
                    />
                    <x-mary-stat
                        title="Jumlah Soal"
                        value="{{ $paketSoal->soals->count() }}"
                        icon="o-document-text"
                        color="success"
                    />
                </div>
            </x-mary-card>

            <!-- Soal List -->
            <div class="space-y-8">
                @foreach ($paketSoal->soals as $index => $soal)
                    <x-mary-card class="relative overflow-hidden">
                        <!-- Decorative Elements -->
                        <div
                            class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-gradient-to-br from-primary-500/10 to-primary-600/5 blur-2xl"
                        ></div>
                        <div
                            class="absolute -bottom-8 -left-8 h-24 w-24 rounded-full bg-gradient-to-tr from-secondary-500/10 to-secondary-600/5 blur-xl"
                        ></div>

                        <!-- Question Header -->
                        <div class="mb-8 flex items-center gap-4">
                            <div class="flex items-center gap-3">
                                <!-- Question Number -->
                                <div class="group relative">
                                    <div
                                        class="absolute -inset-0.5 rounded-xl bg-gradient-to-r from-primary-600 to-secondary-600 opacity-30 blur transition duration-1000 group-hover:opacity-50"
                                    ></div>
                                    <div
                                        class="relative flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 shadow-lg shadow-primary-500/30"
                                    >
                                        <span
                                            class="text-2xl font-black text-white"
                                        >
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Question Type Badge -->
                                <div
                                    class="flex items-center rounded-lg border border-secondary-200 bg-gradient-to-r from-secondary-500/20 via-secondary-500/10 to-transparent px-4 py-2 backdrop-blur-sm"
                                >
                                    <x-mary-icon
                                        name="{{ $soal->jenis_soal === 'essay' ? 'o-pencil-square' : 'o-check-circle' }}"
                                        class="mr-2 h-5 w-5 text-secondary-600"
                                    />
                                    <span
                                        class="font-semibold tracking-wide text-secondary-700"
                                    >
                                        {{ ucfirst($soal->jenis_soal) }}
                                    </span>
                                </div>
                            </div>
                            <div
                                class="h-1 w-full rounded-full bg-gradient-to-r from-gray-200 via-gray-100 to-transparent"
                            ></div>
                        </div>

                        <!-- Question Text -->
                        <div
                            class="mb-8 rounded-xl border border-gray-100 bg-gray-50/50 px-4 py-3 text-xl font-medium leading-relaxed text-gray-800 shadow-inner"
                        >
                            {{ $soal->pertanyaan }}
                        </div>

                        <!-- Answer Options -->
                        <div class="space-y-4 pl-8">
                            @if ($soal->jenis_soal === "essay")
                                <x-mary-card
                                    class="border-primary-200 bg-gradient-to-r from-primary-50 to-primary-100/30"
                                >
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="text-xl font-black text-primary-700"
                                        >
                                            {{ chr(64 + $loop->iteration) }}.
                                        </span>
                                        <span class="text-lg text-primary-900">
                                            {{ $soal->kunci_essay ?? "-" }}
                                        </span>
                                    </div>
                                </x-mary-card>
                            @endif

                            @foreach ($soal->soalOpsiRelation as $opsi)
                                <x-mary-card
                                    class="relative group {{ $opsi->is_jawaban ? 'bg-gradient-to-r from-emerald-50 to-emerald-100/50' : 'bg-gradient-to-r from-gray-50 to-white' }} border {{ $opsi->is_jawaban ? 'border-emerald-200' : 'border-gray-200' }} shadow-sm hover:shadow-lg transition-all duration-300"
                                >
                                    <!-- Hover Effect -->
                                    <div
                                        class="{{ $opsi->is_jawaban ? "from-emerald-400/5 to-emerald-500/5" : "from-gray-400/5 to-gray-500/5" }} absolute inset-0 rounded-xl bg-gradient-to-r opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                    ></div>

                                    <div
                                        class="relative flex items-center gap-4"
                                    >
                                        <!-- Option Letter -->
                                        <div
                                            class="{{ $opsi->is_jawaban ? "bg-emerald-100 text-emerald-700" : "bg-gray-100 text-gray-700" }} flex h-10 w-10 items-center justify-center rounded-lg shadow-inner"
                                        >
                                            <span class="text-lg font-black">
                                                {{ chr(64 + $loop->iteration) }}
                                            </span>
                                        </div>

                                        <!-- Option Text -->
                                        <span
                                            class="{{ $opsi->is_jawaban ? "font-semibold text-emerald-700" : "text-gray-700" }} flex-1 text-lg leading-relaxed"
                                        >
                                            {{ $opsi->teks }}
                                        </span>

                                        <!-- Correct Answer Badge -->
                                        @if ($opsi->is_jawaban)
                                            <div
                                                class="flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-100 to-emerald-200 px-4 py-1.5 text-emerald-700 shadow-sm"
                                            >
                                                <x-mary-icon
                                                    name="o-check-circle"
                                                    class="h-5 w-5"
                                                />
                                                <span
                                                    class="text-sm font-semibold"
                                                >
                                                    Kunci Jawaban
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </x-mary-card>
                            @endforeach
                        </div>
                    </x-mary-card>
                @endforeach
            </div>
        </div>
    </body>
</html>
