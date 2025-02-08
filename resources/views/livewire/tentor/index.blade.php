<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-sky-50">
    <!-- Scripts -->
    <script>
        function clock() {
            return {
                time: '00:00:00',
                startClock() {
                    setInterval(() => {
                        this.time = new Date().toLocaleTimeString('id-ID', {
                            hour12: false,
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                        });
                    }, 1000);
                },
            };
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('counter', () => ({
                init() {
                    new CountUp('totalSiswa', 150, { duration: 2.5 }).start();
                    new CountUp('totalKelas', 8, { duration: 2.5 }).start();
                    new CountUp('totalMateri', 24, { duration: 2.5 }).start();
                },
            }));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            const attendanceCtx = document.getElementById('attendanceChart')?.getContext('2d');
            if (attendanceCtx) {
                new Chart(attendanceCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                        datasets: [{
                            label: 'Kehadiran Siswa',
                            data: [95, 92, 88, 94, 90, 85],
                            borderColor: 'rgb(79, 70, 229)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            const averageScoreCtx = document.getElementById('averageScoreChart')?.getContext('2d');
            if (averageScoreCtx) {
                new Chart(averageScoreCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Matematika', 'Fisika', 'Kimia', 'Biologi'],
                        datasets: [{
                            label: 'Nilai Rata-rata',
                            data: [85, 78, 82, 88],
                            backgroundColor: [
                                'rgba(79, 70, 229, 0.7)',
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(245, 158, 11, 0.7)'
                            ],
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <div class="min-h-screen">
        <div class="p-8">
            <!-- Header & Profile -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2">
                    <x-mary-header title="Dashboard Tentor" subtitle="Selamat datang di sistem CBT" class="mb-0">
                        <x-slot:actions>
                            <div x-data="clock()" x-init="startClock()" class="text-right">
                                <div x-text="time" class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-500">00:00:00</div>
                                <div class="text-sm font-medium text-gray-600">
                                    {{ \Carbon\Carbon::now()->locale("id")->isoFormat("dddd, D MMMM Y") }}
                                </div>
                            </div>
                        </x-slot:actions>
                    </x-mary-header>
                </div>
                <div class="lg:col-span-1">
                    <x-mary-card shadow class="bg-white/80 backdrop-blur-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name=Nama+Tentor&background=6366f1&color=fff" class="w-20 h-20 rounded-xl shadow-md"/>
                                <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900">Nama Tentor</h3>
                                <p class="text-sm font-medium text-gray-600">NIP: 123456789</p>
                                <div class="flex items-center mt-3 space-x-2">
                                    <x-mary-badge label="Matematika" color="primary"/>
                                    <x-mary-badge label="Fisika" color="success"/>
                                </div>
                            </div>
                        </div>
                    </x-mary-card>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <x-mary-stat
                    title="Total Siswa"
                    value="0"
                    icon="o-users"
                    id="totalSiswa"
                    color="primary"
                    class="bg-white/80 backdrop-blur-sm shadow hover:shadow-lg transition-all duration-300"
                />
                <x-mary-stat
                    title="Total Kelas"
                    value="0"
                    icon="o-academic-cap"
                    id="totalKelas"
                    color="success"
                    class="bg-white/80 backdrop-blur-sm shadow hover:shadow-lg transition-all duration-300"
                />
                <x-mary-stat
                    title="Total Materi"
                    value="0"
                    icon="o-book-open"
                    id="totalMateri"
                    color="warning"
                    class="bg-white/80 backdrop-blur-sm shadow hover:shadow-lg transition-all duration-300"
                />
                <x-mary-stat
                    title="Tugas Belum Dinilai"
                    value="5"
                    icon="o-document-text"
                    color="error"
                    class="bg-white/80 backdrop-blur-sm shadow hover:shadow-lg transition-all duration-300"
                />
            </div>

            <!-- Menu Shortcuts -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <x-mary-button icon="o-academic-cap" label="Daftar Siswa" color="primary" class="w-full justify-center py-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300"/>
                <x-mary-button icon="o-book-open" label="Materi" color="success" class="w-full justify-center py-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300"/>
                <x-mary-button icon="o-clipboard-document-list" label="Tugas" color="warning" class="w-full justify-center py-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300"/>
                <x-mary-button icon="o-chart-bar" label="Laporan" color="error" class="w-full justify-center py-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300"/>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Jadwal Mengajar -->
                <div class="lg:col-span-2">
                    <x-mary-card title="Jadwal Mengajar Hari Ini" shadow class="bg-white/80 backdrop-blur-sm">
                        <div class="overflow-x-auto">
                            <div class="grid grid-cols-1 gap-4">
                                @forelse ($jadwalBelajar as $jadwal)
                                    <x-mary-card class="bg-white/80 backdrop-blur-sm hover:shadow-lg transition-all duration-300">
                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                            <div class="flex items-center gap-4">
                                                <div class="bg-indigo-100 rounded-lg p-3">
                                                    <x-mary-icon name="o-clock" class="w-6 h-6 text-indigo-600"/>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                                                    <h4 class="text-lg font-semibold text-gray-900">{{ $jadwal->mataPelajaran->nama_pelajaran }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $jadwal->kelasBimbel->nama_kelas }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-4">
                                                @if ($jadwal->status == "aktif")
                                                    <x-mary-badge label="Menunggu" color="warning"/>
                                                @else
                                                    <x-mary-badge label="Selesai" color="success"/>
                                                @endif

                                                <div class="flex gap-2">
                                                    <x-mary-button
                                                        icon="o-clipboard-document-list"
                                                        href="{{ route('tentor.absensi', $jadwal->id) }}"
                                                        label="Absensi"
                                                        size="sm"
                                                        color="success"
                                                        class="shadow-sm hover:shadow-md transition-all duration-300"
                                                    />
                                                    <x-mary-button
                                                        icon="o-eye"
                                                        label="Detail"
                                                        size="sm"
                                                        color="primary"
                                                        class="shadow-sm hover:shadow-md transition-all duration-300"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </x-mary-card>
                                @empty
                                    <x-mary-card class="bg-white/80 backdrop-blur-sm">
                                        <div class="flex flex-col items-center justify-center py-6">
                                            <x-mary-icon name="o-calendar" class="w-16 h-16 text-gray-400 mb-3"/>
                                            <p class="text-gray-500 font-medium">Tidak ada jadwal mengajar hari ini</p>
                                        </div>
                                    </x-mary-card>
                                @endforelse
                            </div>
                        </div>
                    </x-mary-card>
                </div>

                <!-- Agenda -->
                <div class="lg:col-span-1">
                    <x-mary-card title="Agenda Mendatang" shadow class="bg-white/80 backdrop-blur-sm">
                        <div class="space-y-4">
                            @foreach(range(1, 3) as $index)
                                <div class="flex items-center space-x-4 p-4 bg-gray-50/80 rounded-xl hover:bg-gray-100/80 transition-all duration-300">
                                    <div class="text-center bg-white p-3 rounded-xl shadow-sm">
                                        <p class="text-sm font-bold text-indigo-600">APR</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ 15 + $index }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-base font-semibold text-gray-900">Ujian Tengah Semester</h5>
                                        <p class="text-sm font-medium text-gray-600">08:00 - 10:00 WIB</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-mary-card>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <x-mary-card title="Grafik Kehadiran Siswa" shadow class="bg-white/80 backdrop-blur-sm">
                    <div class="h-80">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </x-mary-card>

                <x-mary-card title="Nilai Rata-rata Kelas" shadow class="bg-white/80 backdrop-blur-sm">
                    <div class="h-80">
                        <canvas id="averageScoreChart"></canvas>
                    </div>
                </x-mary-card>
            </div>
        </div>
    </div>
</div>
