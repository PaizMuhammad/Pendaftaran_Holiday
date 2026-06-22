<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Keberangkatan Umrah | Holiday Angkasa Wisata</title>
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
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="font-luxury text-gold font-bold tracking-widest text-base uppercase">Holiday Angkasa</h1>
            <a href="{{ route('user.dashboard') }}" class="bg-zinc-900 border border-zinc-800 hover:border-gold text-zinc-400 hover:text-gold px-4 py-1.5 rounded-full text-[10px] font-bold transition-all uppercase tracking-widest flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6 md:p-8">
        <div class="mb-8 text-center md:text-left">
            <h2 class="font-luxury text-2xl md:text-3xl font-bold text-white tracking-tighter uppercase">Informasi Keberangkatan</h2>
            <p class="text-gold text-[10px] tracking-[0.3em] font-bold uppercase mt-2">Detail Jadwal, Manasik, Maskapai & Anggota Keluarga Anda</p>
            <div class="h-[1px] w-20 bg-gold mt-4 mx-auto md:mx-0"></div>
        </div>

        @if(!$kloter || $jemaahList->isEmpty())
            <div class="bg-zinc-900/90 border border-zinc-800 p-8 rounded-2xl text-center shadow-xl">
                <div class="w-16 h-16 bg-zinc-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-zinc-700">
                    <i class="fas fa-clock text-gold text-2xl animate-pulse"></i>
                </div>
                <h3 class="font-luxury text-lg text-white font-bold uppercase tracking-wider mb-2">Kloter Belum Ditentukan</h3>
                <p class="text-zinc-500 text-xs max-w-md mx-auto leading-relaxed">
                    Pendaftaran anggota keluarga Anda telah diverifikasi. Saat ini admin sedang menyusun plot bus dan manifes penerbangan. Informasi jadwal keberangkatan akan muncul otomatis jika admin sudah memasukkan nama jemaah ke dalam grup kloter.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 bg-zinc-900/90 border border-zinc-800 rounded-2xl p-6 shadow-xl space-y-6">
                    <div class="border-b border-zinc-800 pb-4 flex justify-between items-start">
                        <div>
                            <span class="text-[9px] bg-gold/10 text-gold border border-gold/30 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-widest mb-1.5 inline-block">Grup Resmi</span>
                            <h3 class="font-luxury text-xl font-bold text-white uppercase tracking-wide">{{ $kloter->nama_kloter }}</h3>
                        </div>
                        <i class="fas fa-kaaba text-zinc-700 text-3xl"></i>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div class="bg-black/40 border border-zinc-800/60 p-3 rounded-xl">
                            <span class="text-[9px] text-zinc-500 font-bold uppercase tracking-wider block mb-1">✈️ Maskapai</span>
                            <span class="font-semibold text-zinc-200 text-sm">{{ $kloter->maskapai }}</span>
                        </div>
                        <div class="bg-black/40 border border-zinc-800/60 p-3 rounded-xl">
                            <span class="text-[9px] text-zinc-500 font-bold uppercase tracking-wider block mb-1">📅 Tanggal Berangkat</span>
                            <span class="font-semibold text-zinc-200 text-sm">{{ date('d M Y', strtotime($kloter->tanggal_keberangkatan)) }}</span>
                        </div>
                        <div class="bg-black/40 border border-zinc-800/60 p-3 rounded-xl">
                            <span class="text-[9px] text-zinc-500 font-bold uppercase tracking-wider block mb-1">🕒 Jam Terbang</span>
                            <span class="font-semibold text-zinc-200 text-sm">Pukul {{ date('H:i', strtotime($kloter->jam_keberangkatan)) }} WIB</span>
                        </div>
                        <div class="bg-black/40 border border-zinc-800/60 p-3 rounded-xl">
                            <span class="text-[9px] text-zinc-500 font-bold uppercase tracking-wider block mb-1">⏳ Durasi Paket</span>
                            <span class="font-semibold text-zinc-200 text-sm">{{ $kloter->lama_keberangkatan }}</span>
                        </div>
                    </div>

                    <div class="border-t border-zinc-800 pt-4">
                        <h4 class="text-[10px] text-gold font-bold uppercase tracking-widest mb-3 flex items-center gap-1.5">
                            <i class="fas fa-users"></i> Anggota Jemaah Yang Berangkat (Akun Ini)
                        </h4>
                        <div class="space-y-2">
                            @foreach($jemaahList as $index => $j)
                                <div class="bg-zinc-800/40 border border-zinc-800 p-3 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 bg-gold/10 border border-gold/20 text-gold text-xs rounded-full flex items-center justify-center font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-zinc-200 uppercase">{{ $j->nama_lengkap }}</p>
                                            <p class="text-[9px] text-zinc-500 tracking-wider font-medium uppercase">Kategori: {{ $j->kategori }}</p>
                                        </div>
                                    </div>
                                    <span class="text-[9px] bg-green-900/20 text-green-400 border border-green-900/50 px-2 py-0.5 rounded-md font-bold uppercase tracking-wider">
                                        Siap Terbang
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="text-[10px] text-gold font-bold uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <i class="fas fa-concierge-bell"></i> Fasilitas Eksklusif Selama Umrah
                        </h4>
                        <div class="bg-black/30 border border-zinc-800/60 rounded-xl p-4 text-xs text-zinc-400 whitespace-pre-line leading-relaxed">
                            {{ $kloter->fasilitas }}
                        </div>
                    </div>
                </div>

                <div class="bg-zinc-900/90 border border-zinc-800 rounded-2xl p-6 shadow-xl flex flex-col">
                    <h3 class="font-luxury text-gold text-xs font-bold uppercase tracking-widest mb-4 border-b border-zinc-800 pb-3 flex items-center gap-1.5">
                        <i class="fas fa-route"></i> Itinerary / Rundown
                    </h3>
                    <div class="flex-1 overflow-y-auto max-h-[420px] pr-1 text-xs text-zinc-400 whitespace-pre-line leading-relaxed">
                        {{ $kloter->rundown }}
                    </div>
                    <div class="mt-4 pt-3 border-t border-zinc-800 text-center">
                        <p class="text-[9px] text-zinc-600 uppercase font-medium tracking-wider">Note: Jadwal sewaktu-waktu dapat berubah menyesuaikan otoritas bandara arab saudi.</p>
                    </div>
                </div>

            </div>
        @endif
    </div>

</body>
</html>