<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Detail Jadwal - {{ $jadwal->nama_jadwal }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts
    </head>

    <body>
        <style>
            @page {
                margin: 0;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                color: #333;
                line-height: 1.6;
            }

            .wrapper {
                padding: 20px 40px;
            }

            .header-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 20px 40px;
                color: white;
            }

            .logo-container {
                text-align: center;
            }

            .logo {
                width: 80px;
                height: auto;
            }

            .header-content {
                text-align: center;
            }

            .header-title {
                font-size: 24px;
                font-weight: bold;
                margin: 0;
                text-transform: uppercase;
                letter-spacing: 2px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            }

            .header-subtitle {
                font-size: 14px;
                margin: 3px 0;
                opacity: 0.9;
            }

            .jadwal-title {
                font-size: 24px;
                color: #4a5568;
                text-align: center;
                margin: 20px 0;
                padding-bottom: 10px;
                border-bottom: 2px solid #e2e8f0;
            }

            .status {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-top: 15px;
            }

            .status-aktif {
                background-color: #c6f6d5;
                color: #2f855a;
                border: 2px solid #9ae6b4;
            }

            .status-nonaktif {
                background-color: #fed7d7;
                color: #9b2c2c;
                border: 2px solid #feb2b2;
            }

            .section {
                background: white;
                border-radius: 15px;
                padding: 25px;
                margin-bottom: 30px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }

            .section-title {
                font-size: 20px;
                font-weight: bold;
                color: #1a202c;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid #edf2f7;
                position: relative;
            }

            .section-title:after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 50px;
                height: 2px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .info-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
                margin-bottom: 20px;
            }

            .info-item {
                background: #f8fafc;
                padding: 15px;
                border-radius: 10px;
                border: 1px solid #e2e8f0;
            }

            .info-label {
                font-size: 13px;
                color: #718096;
                margin-bottom: 5px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .info-value {
                font-size: 15px;
                color: #2d3748;
                font-weight: 600;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
                font-size: 14px;
                background: white;
                border-radius: 10px;
                overflow: hidden;
            }

            th {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 0.5px;
                padding: 12px;
                text-align: left;
            }

            td {
                padding: 12px;
                border-bottom: 1px solid #e2e8f0;
            }

            tr:last-child td {
                border-bottom: none;
            }

            tr:nth-child(even) {
                background-color: #f8fafc;
            }

            .footer {
                margin-top: 50px;
                text-align: center;
                font-size: 12px;
                color: #718096;
                padding-top: 20px;
                border-top: 2px solid #edf2f7;
            }

            .empty-state {
                text-align: center;
                padding: 40px;
                color: #718096;
            }

            .empty-state-icon {
                font-size: 48px;
                margin-bottom: 20px;
                color: #a0aec0;
            }
        </style>
    </head>

    <body>
        <div class="header-bg">
            <div class="logo-container">
                <img
                    src="{{ public_path("images/logo.webp") }}"
                    alt="Logo"
                    class="logo"
                />
            </div>
            <div class="header-content">
                <h1 class="header-title">Bimbingan Belajar Sinteta</h1>
                <p class="header-subtitle">Detail Jadwal Pembelajaran</p>
            </div>
        </div>

        <div class="wrapper">
            <div class="jadwal-title">
                {{ $jadwal->nama_jadwal }}
            </div>

            <div class="section">
                <div class="section-title">Informasi Jadwal</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Mata Pelajaran</div>
                        <div class="info-value">
                            {{ $jadwal->mataPelajaran->nama_pelajaran }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tentor</div>
                        <div class="info-value">
                            {{ $jadwal->tentor->user->name }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Hari & Waktu</div>
                        <div class="info-value">
                            {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} -
                            {{ $jadwal->jam_selesai }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ruangan</div>
                        <div class="info-value">{{ $jadwal->ruangan }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kelas</div>
                        <div class="info-value">
                            {{ $jadwal->kelasBimbel->nama_kelas }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kapasitas</div>
                        <div class="info-value">
                            {{ $jadwal->jumlah_siswa }}/{{ $jadwal->kapasitas }}
                            Siswa
                        </div>
                    </div>
                    @if ($jadwal->catatan)
                        <div class="info-item">
                            <div class="info-label">Catatan</div>
                            <div class="info-value">
                                {{ $jadwal->catatan }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="section">
                <div class="section-title">Daftar Siswa</div>
                @if ($jadwal->kelasBimbel->siswa->where("status", "aktif")->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 40px">No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th style="width: 100px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal->kelasBimbel->siswa->where("status", "aktif") as $index => $siswa)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $siswa->nama_lengkap }}</td>
                                    <td>{{ $siswa->email }}</td>
                                    <td>
                                        <div
                                            class="status {{ $siswa->status === "aktif" ? "status-aktif" : "status-nonaktif" }}"
                                        >
                                            {{ ucfirst($siswa->status) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">👥</div>
                        <p>Belum ada siswa yang terdaftar</p>
                    </div>
                @endif
            </div>

            <div class="footer">
                <p>
                    © {{ date("Y") }} Bimbingan Belajar Sinteta. Dokumen ini
                    digenerate secara otomatis pada
                    {{ now()->format("d F Y H:i:s") }}
                </p>
            </div>
        </div>
    </body>
</html>
