<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Holiday Angkasa Wisata</title>
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

    <!-- Navigasi -->
    <nav class="border-b border-zinc-800 p-4 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="font-luxury text-gold font-bold tracking-widest text-xl uppercase">Admin Panel</h1>
            <div class="flex items-center gap-4 md:gap-6">
                <span class="text-xs text-zinc-400 font-medium tracking-widest uppercase hidden md:inline">Admin: {{ Auth::user()->name }}</span>
                
                <!-- 👑 TOMBOL REVISI DOSEN: MENU KELOLA KLOTER UMRAH (TAMPILAN LUXURY EMAS) -->
                <a href="{{ route('admin.kloter.index') }}" class="bg-gold hover:bg-yellow-600 text-black px-4 py-1.5 rounded-full text-[10px] font-bold transition-all uppercase tracking-widest flex items-center gap-1.5 shadow-lg shadow-yellow-600/20">
                    <i class="fas fa-layer-group"></i> Kelola Kloter
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-900/20 text-red-500 border border-red-900/50 px-4 py-1.5 rounded-full text-[10px] font-bold hover:bg-red-900 hover:text-white transition-all uppercase tracking-widest">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 md:p-8">
        
        <!-- Header -->
        <div class="mb-10">
            <h2 class="font-luxury text-3xl font-bold text-white tracking-tighter uppercase">Data Pendaftaran Jemaah</h2>
            <p class="text-gold text-[10px] tracking-[0.3em] font-bold uppercase mt-2">Holiday Angkasa Wisata Management</p>
            <div class="h-[1px] w-20 bg-gold mt-4"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-500 p-4 rounded-xl mb-6 text-xs font-bold uppercase tracking-widest animate-fade-in">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- BAR PENCARIAN & FILTER -->
        <div class="mb-6 bg-zinc-900/90 border border-zinc-800 p-6 rounded-2xl shadow-xl">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-2 block">Cari Nama / NIK</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-zinc-600 text-xs"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Masukkan nama jemaah..." 
                               class="w-full bg-black border border-zinc-800 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:border-gold outline-none transition-all placeholder:text-zinc-700 text-white">
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-2 block">Kategori</label>
                    <select name="kategori" class="w-full bg-black border border-zinc-800 rounded-xl py-2.5 px-4 text-sm focus:border-gold outline-none text-zinc-300">
                        <option value="">Semua</option>
                        <option value="umroh" {{ ($kategori ?? '') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                        <option value="haji" {{ ($kategori ?? '') == 'haji' ? 'selected' : '' }}>Haji</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none bg-gold hover:bg-yellow-600 text-black px-8 py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                        Cari
                    </button>
                    @if($search || $kategori)
                        <a href="{{ route('admin.dashboard') }}" class="bg-zinc-800 hover:bg-zinc-700 text-zinc-400 px-4 py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Kontainer -->
        <div class="bg-zinc-900/90 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-800/50 text-gold text-[10px] uppercase tracking-[0.2em] border-b border-zinc-800">
                            <th class="p-5 font-bold">Informasi Jemaah</th>
                            <th class="p-5 font-bold">Paket Pilihan</th>
                            <th class="p-5 font-bold">Ceklis Dokumen</th>
                            <th class="p-5 font-bold text-center">Status</th>
                            <th class="p-5 font-bold text-right">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800">
                        @foreach($pilgrims as $p)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="p-5">
                                <div class="font-bold text-zinc-100 group-hover:text-gold transition-colors">{{ $p->nama_lengkap }}</div>
                                <div class="text-[10px] text-zinc-500 mt-1 uppercase">NIK: {{ $p->nik }}</div>
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('view.document', $p->foto_ktp) }}" target="_blank" class="bg-zinc-800 hover:bg-gold hover:text-black px-2 py-1 rounded text-[9px] font-bold transition-all uppercase">
                                        <i class="fas fa-id-card mr-1"></i> KTP
                                    </a>
                                    <a href="{{ route('view.document', $p->foto_kk) }}" target="_blank" class="bg-zinc-800 hover:bg-gold hover:text-black px-2 py-1 rounded text-[9px] font-bold transition-all uppercase">
                                        <i class="fas fa-users mr-1"></i> KK
                                    </a>
                                </tr>
                            </td>

                            <td class="p-5 text-sm">
                                <div class="font-semibold text-zinc-300">
                                    @if($p->package)
                                        {{ $p->package->nama_paket }}
                                    @else
                                        <span class="text-gold italic font-bold">Pendaftaran {{ ucfirst($p->kategori) }}</span>
                                    @endif
                                </div>
                                <div class="text-[10px] text-zinc-500 italic mt-1 uppercase tracking-tighter">
                                    @if($p->package)
                                        Hotel: {{ $p->package->jarak_hotel }}
                                    @else
                                        <i class="fas fa-clock mr-1"></i> Menunggu Konfirmasi Admin
                                    @endif
                                </div>
                            </td>

                            <td class="p-5">
                                <form action="{{ route('admin.update_status', $p->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-1">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="paspor" {{ $p->is_paspor_received ? 'checked' : '' }} class="w-3.5 h-3.5 rounded border-zinc-700 bg-black text-gold">
                                            <span class="text-[9px] text-zinc-400 uppercase font-bold">Paspor</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="vaksin" {{ $p->is_vaksin_received ? 'checked' : '' }} class="w-3.5 h-3.5 rounded border-zinc-700 bg-black text-gold">
                                            <span class="text-[9px] text-zinc-400 uppercase font-bold">Vaksin</span>
                                        </label>
                                    </div>
                                    <button type="submit" class="text-[8px] text-zinc-600 hover:text-gold uppercase font-bold underline">Update</button>
                                </form>
                            </td>

                            <td class="p-5 text-center">
                                @if($p->status == 'Verified')
                                    <span class="inline-flex items-center gap-1.5 bg-green-900/20 text-green-500 border border-green-900/50 px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-widest">
                                        <i class="fas fa-check-double"></i> Verified
                                    </span>
                                @else
                                    <form action="{{ route('admin.verify', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-white/5 hover:bg-green-600 text-zinc-400 hover:text-white border border-white/10 hover:border-green-600 px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td class="p-5 text-right">
                                <div class="flex flex-col gap-1">
                                    <span class="text-[9px] text-zinc-100 font-bold uppercase">{{ $p->created_at->format('d M Y') }}</span>
                                    <span class="text-[9px] text-zinc-600 font-bold uppercase">{{ $p->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($pilgrims->isEmpty())
                <div class="p-20 text-center">
                    <i class="fas fa-search text-4xl text-zinc-800 mb-4"></i>
                    <p class="text-zinc-600 text-xs font-bold uppercase tracking-[0.3em]">Data tidak ditemukan</p>
                </div>
            @endif
        </div>
    </div>

</body>
</html>