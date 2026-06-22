<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kloter | Holiday Angkasa Wisata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-luxury { font-family: 'Cinzel', serif; }
        .text-gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; }
        .bg-pattern { background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png'); }
    </style>
</head>
<body class="bg-black bg-pattern min-h-screen text-white">

    <nav class="border-b border-zinc-800 p-4 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="font-luxury text-gold font-bold tracking-widest text-xl uppercase">Admin Panel</h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-zinc-900 border border-zinc-800 hover:border-gold text-zinc-400 hover:text-gold px-4 py-1.5 rounded-full text-[10px] font-bold transition-all uppercase tracking-widest flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 md:p-8">
        <div class="mb-10">
            <h2 class="font-luxury text-3xl font-bold text-white tracking-tighter uppercase">Manajemen Kloter Umrah</h2>
            <p class="text-gold text-[10px] tracking-[0.3em] font-bold uppercase mt-2">Pembuatan Grup & Jadwal Keberangkatan Massal</p>
            <div class="h-[1px] w-20 bg-gold mt-4"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-500 p-4 rounded-xl mb-6 text-xs font-bold uppercase tracking-widest">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-zinc-900/90 border border-zinc-800 p-6 rounded-2xl shadow-xl h-fit">
                <h3 class="font-luxury text-gold text-sm font-bold uppercase tracking-wider mb-4 border-b border-zinc-800 pb-2">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Kloter Baru
                </h3>
                <form action="{{ route('admin.kloter.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Nama Kloter</label>
                        <input type="text" name="nama_kloter" placeholder="Contoh: Kloter 1 Gold" class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Tanggal Keberangkatan</label>
                        <input type="date" name="tanggal_keberangkatan" class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all text-zinc-300" required>
                    </div>
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Maskapai Pesawat</label>
                        <input type="text" name="maskapai" placeholder="Contoh: Saudi Arabian Airlines" class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Jam Terbang</label>
                            <input type="time" name="jam_keberangkatan" class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all text-zinc-300" required>
                        </div>
                        <div>
                            <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Lama Hari</label>
                            <input type="text" name="lama_keberangkatan" placeholder="Contoh: 9 Hari" class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all" required>
                        </div>
                    </div>
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Fasilitas Berangkat</label>
                        <textarea name="fasilitas" rows="2" placeholder="Contoh: Hotel Bintang 5, Bus Full AC, Makan 3x Sehari" class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all placeholder:text-zinc-700" required></textarea>
                    </div>
                    <div>
                        <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1.5 block">Rundown Acara</label>
                        <textarea name="rundown" rows="3" placeholder="Contoh: Hari 1: Kumpul Bandara&#10;Hari 2: Menuju Madinah..." class="w-full bg-black border border-zinc-800 rounded-xl py-2 px-4 text-sm focus:border-gold outline-none transition-all placeholder:text-zinc-700" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gold hover:bg-yellow-600 text-black py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-yellow-600/10">
                        Simpan Kloter Baru
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-zinc-900/90 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl h-fit">
                <div class="p-6 border-b border-zinc-800 bg-zinc-800/20">
                    <h3 class="font-luxury text-gold text-sm font-bold uppercase tracking-wider">
                        <i class="fas fa-layer-group mr-2"></i> Daftar Kloter Aktif
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-800/50 text-gold text-[10px] uppercase tracking-[0.2em] border-b border-zinc-800">
                                <th class="p-5 font-bold">Detail Kloter</th>
                                <th class="p-5 font-bold">Penerbangan</th>
                                <th class="p-5 font-bold text-center">Anggota</th>
                                <th class="p-5 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800">
                            @forelse($kloters as $k)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="p-5">
                                    <div class="font-bold text-zinc-100 text-base">{{ $k->nama_kloter }}</div>
                                    <div class="text-[10px] text-zinc-500 mt-1 uppercase">📅 {{ date('d M Y', strtotime($k->tanggal_keberangkatan)) }}</div>
                                </td>
                                <td class="p-5 text-xs text-zinc-400">
                                    <div class="font-medium text-zinc-200">✈️ {{ $k->maskapai }}</div>
                                    <div class="text-[10px] text-zinc-600 mt-1 uppercase">🕒 Jam {{ $k->jam_keberangkatan }} | ⏳ {{ $k->lama_keberangkatan }}</div>
                                </td>
                                <td class="p-5 text-center">
                                    <span class="inline-flex items-center bg-yellow-900/20 text-gold border border-yellow-900/50 px-2.5 py-0.5 rounded-full text-[10px] font-bold">
                                        {{ $k->jemaahs_count ?? 0 }} Jemaah
                                    </span>
                                </td>
                                <td class="p-5 text-right">
                                    <a href="{{ route('admin.kloter.jemaah', $k->id) }}" class="bg-zinc-800 hover:bg-gold text-zinc-300 hover:text-black border border-zinc-700 hover:border-gold px-3 py-1.5 rounded-xl text-[9px] font-bold transition-all uppercase tracking-widest inline-block">
                                        <i class="fas fa-users-cog mr-1"></i> Kelola Jemaah
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-zinc-600 text-xs font-bold uppercase tracking-wider">
                                    Belum ada grup kloter yang dibuat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>