<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Jadwal Belajar</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts
        <style>
            @page {
                margin: 0;
                size: landscape;
            }

            body {
                font-family: 'Poppins', sans-serif;
                padding: 20px;
                width: 100%;
                text-align: center;
                background: linear-gradient(135deg, #f6f8ff 0%, #f9f0ff 100%);
            }

            .container {
                width: 100%;
                background: rgba(255, 255, 255, 0.98);
                border-radius: 25px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.15);
                padding: 30px;
                backdrop-filter: blur(20px);
                margin: 0 auto;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0 8px;
                margin: 20px auto 0;
                border-radius: 20px;
                overflow: hidden;
                font-size: 13px;
            }

            .table th,
            .table td {
                padding: 15px;
                text-align: center;
                border: none;
            }

            .table th {
                background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
                color: white;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.12em;
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .table tbody tr {
                background: white;
                box-shadow: 0 3px 10px rgba(0,0,0,0.05);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .table tbody tr:hover {
                transform: translateY(-3px) scale(1.01);
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
                background: linear-gradient(135deg, rgba(65, 88, 208, 0.02) 0%, rgba(200, 80, 192, 0.02) 100%);
            }

            .header {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 25px;
                background: linear-gradient(135deg, rgba(65, 88, 208, 0.08) 0%, rgba(200, 80, 192, 0.08) 100%);
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                margin-bottom: 25px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.4);
            }

            .logo {
                width: 120px;
                height: auto;
                margin-right: 25px;
                filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(2deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }

            .title {
                flex-grow: 1;
                text-align: center;
                position: relative;
            }

            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 180px;
                opacity: 0.025;
                background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-weight: 900;
                z-index: -1;
                white-space: nowrap;
                letter-spacing: 8px;
                filter: blur(1px);
            }

            .badge {
                padding: 6px 12px;
                border-radius: 12px;
                font-size: 0.8rem;
                font-weight: 600;
                background: linear-gradient(135deg, rgba(65, 88, 208, 0.15) 0%, rgba(200, 80, 192, 0.15) 100%);
                border: 1px solid rgba(200, 80, 192, 0.2);
                backdrop-filter: blur(8px);
                margin: 0 auto;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                color: #4158D0;
            }

            .footer {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 2px solid rgba(200, 80, 192, 0.15);
                text-align: center;
                background: linear-gradient(135deg, rgba(65, 88, 208, 0.03) 0%, rgba(200, 80, 192, 0.03) 100%);
                border-radius: 0 0 20px 20px;
                padding-bottom: 15px;
            }
        </style>
    </head>

    <body>
        <div class="watermark">SINTETA</div>

        <div class="container">
            <!-- Header dengan Logo -->
            <div class="header">
                <img src="{{ public_path('images/logo.webp') }}" alt="Logo" class="logo">
                <div class="title">
                    <h1 style="background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 24px; font-weight: 800; margin: 0;">🎓 Jadwal Belajar CBT SINTETA</h1>
                    <p>Tanggal: {{ $tanggal }}</p>
                </div>
            </div>

            <!-- Tabel Jadwal -->
            <table class="table" style="margin: 0 auto;">
                <thead>
                    <tr>
                        <th style="width: 4%; text-align: center;">No</th>
                        <th style="width: 20%; text-align: center;">📚 Mata Pelajaran</th>
                        <th style="width: 15%; text-align: center;">👥 Kelas</th>
                        <th style="width: 15%; text-align: center;">👨‍🏫 Tentor</th>
                        <th style="width: 12%; text-align: center;">⏰ Jam</th>
                        <th style="width: 12%; text-align: center;">🏫 Ruangan</th>
                        <th style="text-align: center;">📝 Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwals as $index => $jadwal)
                        <tr>
                            <td style="font-weight: 700; background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-align: center;">{{ $index + 1 }}</td>
                            <td style="font-weight: 600; text-align: center;">{{ $jadwal->mataPelajaran->nama_pelajaran }}</td>
                            <td style="text-align: center;">{{ $jadwal->kelasBimbel->nama_kelas }}</td>
                            <td style="text-align: center;">{{ $jadwal->tentor->user->name }}</td>
                            <td style="text-align: center;">
                                <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background: rgba(65, 88, 208, 0.1); color: #4158D0; border: 1px solid rgba(65, 88, 208, 0.2);">
                                    {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                </span>
                            </td>
                            <td style="text-align: center;">{{ $jadwal->ruangan->nama }}</td>
                            <td style="text-align: center;">{{ $jadwal->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Footer -->
            <div class="footer">
                <p style="color: #6b7280; font-size: 11px; margin: 0;">
                    🖨️ Dicetak pada {{ now()->isoFormat('dddd, D MMMM Y HH:mm:ss') }}
                </p>
                <p style="background: linear-gradient(135deg, #4158D0 0%, #C850C0 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700; font-size: 12px; margin: 4px 0 0 0;">
                    © {{ date('Y') }} CBT SINTETA - Your Future Starts Here! ✨
                </p>
            </div>
        </div>
    </body>
</html>
