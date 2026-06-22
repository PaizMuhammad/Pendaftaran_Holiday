<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Jemaah | Holiday Angkasa Wisata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-gold { background-color: #D4AF37; }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .card-hover:hover { transform: translateY(-5px); border-color: #D4AF37; }
    </style>
</head>
<body class="bg-black text-white font-sans">
    <nav class="border-b border-zinc-800 p-4 flex justify-between items-center bg-zinc-900">
        <h1 class="text-gold font-bold tracking-widest text-xl uppercase">Holiday Angkasa Wisata</h1>
        <div class="flex items-center gap-4">
    <span class="text-sm text-zinc-400 font-medium">Halo, {{ Auth::user()->name }}</span>
    <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf <button type="submit" class="bg-red-900/20 text-red-500 border border-red-900 px-3 py-1 rounded text-xs hover:bg-red-900 hover:text-white transition">Keluar</button>
    </form>
</div>
    </nav>

    <div class="max-w-6xl mx-auto mt-12 p-6 space-y-12">
        
        <!-- ==================== MENU BARU: INFO KEBERANGKATAN (REVISI DOSEN) ==================== -->
        <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-xl shadow-xl">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <h3 class="text-xl font-bold text-white uppercase tracking-wide flex items-center justify-center md:justify-start gap-2">
                        <span>✈️ INFO KEBERANGKATAN JEMAAH</span>
                    </h3>
                    <p class="text-zinc-500 text-sm">Lihat jadwal, maskapai, dan rundown perjalanan Anda.</p>
                </div>
                <div class="w-full md:w-auto shrink-0">
                    <a href="{{ route('user.info-keberangkatan') }}" class="block text-center bg-gold text-black font-bold px-6 py-3.5 rounded-lg hover:bg-yellow-600 transition uppercase text-xs tracking-widest shadow-lg font-semibold">
                        <i class="fas fa-plane-departure mr-1.5"></i> LIHAT JADWAL TERBANG
                    </a>
                </div>
            </div>
        </div>
        <!-- ===================================================================================== -->

        <!-- LAYANAN PENDAFTARAN -->
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-2 uppercase tracking-tighter">Layanan Pendaftaran Online</h2>
            <p class="text-zinc-500">Silakan pilih kategori ibadah untuk memulai pendaftaran.</p>
            
            <div class="grid md:grid-cols-2 gap-8 mt-10">
                <!-- KARTU HAJI -->
                <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl card-hover transition duration-300 shadow-xl">
                    <div class="text-5xl mb-4">🕋</div>
                    <h3 class="text-2xl font-bold mb-4 text-gold uppercase tracking-wider">Pendaftaran Haji</h3>
                    <p class="text-zinc-400 text-sm mb-8">Daftar keberangkatan Haji Khusus dengan pelayanan terbaik.</p>
                    <a href="{{ route('pendaftaran.form', ['kategori' => 'haji']) }}" class="inline-block w-full bg-gold text-black font-bold py-3 rounded-lg hover:bg-yellow-600 transition uppercase text-xs tracking-widest">PILIH HAJI</a>
                </div>

                <!-- KARTU UMRAH -->
                <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-xl card-hover transition duration-300 shadow-xl">
                    <div class="text-5xl mb-4">🕌</div>
                    <h3 class="text-2xl font-bold mb-4 text-gold uppercase tracking-wider">Pendaftaran Umrah</h3>
                    <p class="text-zinc-400 text-sm mb-8">Pilih berbagai paket Umrah dengan kepastian keberangkatan.</p>
                    <a href="{{ route('pendaftaran.form', ['kategori' => 'umroh']) }}" class="inline-block w-full bg-gold text-black font-bold py-3 rounded-lg hover:bg-yellow-600 transition uppercase text-xs tracking-widest">PILIH UMRAH</a>
                </div>
            </div>
        </div>

        <hr class="border-zinc-800">

        <!-- ALERT SUKSES -->
        @if(session('success'))
            <div class="bg-green-900/20 border border-green-500 text-green-500 p-4 rounded-xl text-xs font-bold uppercase tracking-widest">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- TABEL STATUS -->
        <div class="bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-zinc-800 bg-zinc-800/50 flex justify-between items-center">
                <h3 class="text-gold font-bold uppercase tracking-wider text-sm">Status Pendaftaran Anda</h3>
                <span class="text-[10px] text-zinc-500 italic">Data otomatis diperbarui jika Admin melakukan verifikasi</span>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-zinc-500 text-[10px] uppercase tracking-widest border-b border-zinc-800">
                        <th class="p-4 font-semibold">Paket Perjalanan</th>
                        <th class="p-4 font-semibold">Nama Lengkap</th>
                        <th class="p-4 font-semibold">Dokumen</th> 
                        <th class="p-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($riwayat as $r)
                    <tr class="border-b border-zinc-800 hover:bg-zinc-800/30 transition text-xs">
                        <td class="p-4">
                            <!-- PERBAIKAN LOGIKA NAMA PAKET -->
                            <div class="font-bold text-zinc-200">
                                @if($r->package)
                                    {{ $r->package->nama_paket }}
                                @else
                                    Paket {{ ucfirst($r->kategori) }}
                                @endif
                            </div>
                            <div class="mt-1">
                                <span class="px-2 py-0.5 rounded-[4px] text-[9px] font-bold {{ strtolower($r->kategori) == 'haji' ? 'bg-blue-900/30 text-blue-400' : 'bg-green-900/30 text-green-400' }}">
                                    {{ strtoupper($r->kategori) }}
                                </span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-zinc-200">{{ $r->nama_lengkap }}</div>
                            <div class="text-[10px] text-zinc-500">{{ $r->created_at->format('d M Y') }}</div>
                        </td>
                        
                        <td class="p-4">
                            <div class="flex gap-2 text-sm">
                                @if($r->foto_ktp)
                                    <span class="text-green-500" title="KTP Terupload"><i class="fas fa-id-card"></i></span>
                                @else
                                    <span class="text-zinc-700" title="KTP Kosong"><i class="fas fa-id-card"></i></span>
                                @endif

                                @if($r->foto_kk)
                                    <span class="text-green-500" title="KK Terupload"><i class="fas fa-file-invoice"></i></span>
                                @else
                                    <span class="text-zinc-700" title="KK Kosong"><i class="fas fa-file-invoice"></i></span>
                                @endif
                            </div>
                        </td>

                        <td class="p-4 text-center">
                            @if($r->status == 'Pending')
                                <span class="bg-yellow-900/20 text-yellow-500 px-3 py-1 rounded text-[10px] font-bold border border-yellow-900/50 uppercase">Menunggu</span>
                            @elseif($r->status == 'Verified' || $r->status == 'Disetujui')
                                <span class="bg-green-900/20 text-green-500 px-3 py-1 rounded text-[10px] font-bold border border-green-500/50 uppercase">Disetujui</span>
                            @else
                                <span class="bg-red-900/20 text-red-500 px-3 py-1 rounded text-[10px] font-bold border border-red-900/50 uppercase">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-zinc-600 italic text-sm">Belum ada riwayat pendaftaran. Silakan pilih kategori di atas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>