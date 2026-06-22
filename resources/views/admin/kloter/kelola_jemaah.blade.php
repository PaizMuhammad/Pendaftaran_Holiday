<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelompok Jemaah | Holiday Angkasa Wisata</title>
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
            <a href="{{ route('admin.kloter.index') }}" class="bg-zinc-900 border border-zinc-800 hover:border-gold text-zinc-400 hover:text-gold px-4 py-1.5 rounded-full text-[10px] font-bold transition-all uppercase tracking-widest flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> Kembali ke Kloter
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 md:p-8">
        <div class="mb-10">
            <h2 class="font-luxury text-3xl font-bold text-white tracking-tighter uppercase">Kelola Anggota: {{ $kloter->nama_kloter }}</h2>
            <p class="text-gold text-[10px] tracking-[0.2em] font-bold uppercase mt-2">✈️ {{ $kloter->maskapai }} | 📅 Tanggal: {{ date('d M Y', strtotime($kloter->tanggal_keberangkatan)) }}</p>
            <div class="h-[1px] w-20 bg-gold mt-4"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-500 p-4 rounded-xl mb-6 text-xs font-bold uppercase tracking-widest">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- KIRI: DAFTAR JEMAAH YANG YANG BELUM MASUK GRUP -->
            <div class="bg-zinc-900/90 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-5 bg-zinc-800/30 border-b border-zinc-800">
                    <h3 class="text-xs font-bold text-green-500 uppercase tracking-widest"><i class="fas fa-user-plus mr-1"></i> Centang Jemaah untuk Dimasukkan</h3>
                </div>
                <div class="p-6">
                    
                    <!-- FITUR BARU: KOTAK PENCARIAN LIVE -->
                    <div class="mb-4">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-zinc-500">
                                <i class="fas fa-search text-xs"></i>
                            </span>
                            <input type="text" id="inputCariJemaah" onkeyup="cariJemaahSakti()" placeholder="Ketik nama, NIK/KTP, kategori, atau nama paket untuk memfilter..." class="w-full pl-9 pr-4 py-2 bg-black border border-zinc-800 rounded-xl text-xs text-white placeholder-zinc-600 focus:outline-none focus:border-gold transition-all">
                        </div>
                    </div>

                    <form action="{{ route('admin.kloter.gabung', $kloter->id) }}" method="POST">
                        @csrf
                        <div class="max-h-[350px] overflow-y-auto border border-zinc-800 rounded-xl bg-black/50 p-2 mb-4 divide-y divide-zinc-900">
                            <table class="w-full text-left text-xs text-zinc-400">
                                <thead>
                                    <tr class="text-gold text-[10px] uppercase font-bold tracking-wider">
                                        <th class="p-3 text-center" width="15%">Pilih</th>
                                        <th class="p-3">Informasi Lengkap Jemaah</th>
                                        <th class="p-3 text-right">Kategori & Paket</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelJemaahSedia">
                                    @forelse($jemaahSedia as $js)
                                    <tr class="item-jemaah-sedia hover:bg-zinc-900/40 border-b border-zinc-900/50">
                                        <td class="p-3 text-center">
                                            <input type="checkbox" name="jemaah_ids[]" value="{{ $js->id }}" class="w-4 h-4 rounded border-zinc-700 bg-black text-gold focus:ring-0 focus:ring-offset-0">
                                        </td>
                                        <td class="p-3">
                                            <!-- Pembeda Utama: Nama & NIK/ID -->
                                            <div class="font-semibold text-zinc-200 uppercase data-nama">{{ $js->nama_lengkap ?? $js->name }}</div>
                                            <div class="text-[10px] text-zinc-500 font-mono mt-0.5 data-nik">NIK: {{ $js->nik ?? $js->no_ktp ?? 'ID-'.$js->id }}</div>
                                        </td>
                                        <td class="p-3 text-right">
                                            <!-- Pembeda Kedua: Kategori Ibadah & Nama Paket -->
                                            <span class="text-[9px] px-2 py-0.5 rounded-full uppercase font-bold data-kategori {{ strtolower($js->kategori) == 'haji' ? 'bg-blue-950/60 text-blue-400 border border-blue-900/40' : 'bg-green-950/60 text-green-400 border border-green-900/40' }}">
                                                {{ $js->kategori ?? 'Umrah' }}
                                            </span>
                                            <div class="text-[10px] text-zinc-400 mt-1 max-w-[180px] ml-auto truncate data-paket" title="{{ $js->package->nama_paket ?? 'Paket Reguler' }}">
                                                {{ $js->package->nama_paket ?? 'Paket Pilihan Jemaah' }}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="Sedia-kosong">
                                        <td colspan="3" class="p-8 text-center text-zinc-600 font-bold uppercase tracking-wider">Semua jemaah aktif sudah mendapatkan kloter.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($jemaahSedia->count() > 0)
                        <button type="submit" class="w-full bg-green-700 hover:bg-green-600 text-white py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all shadow-lg">
                            ➕ Masukkan Jemaah yang Dipilih
                        </button>
                        @endif
                    </form>
                </div>
            </div>

            <!-- KANAN: DAFTAR JEMAAH YANG SUDAH MASUK KLOTER INI -->
            <div class="bg-zinc-900/90 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl h-fit">
                <div class="p-5 bg-zinc-800/30 border-b border-zinc-800 flex justify-between items-center">
                    <h3 class="text-xs font-bold text-gold uppercase tracking-widest"><i class="fas fa-users mr-1"></i> Anggota Kloter Ini</h3>
                    <span class="text-[10px] font-bold bg-gold/10 text-gold px-2.5 py-0.5 rounded-full border border-gold/20 uppercase tracking-widest">{{ $jemaahKloter->count() }} Orang</span>
                </div>
                <div class="max-h-[434px] overflow-y-auto divide-y divide-zinc-800">
                    <table class="w-full text-left text-xs">
                        <tbody>
                            @forelse($jemaahKloter as $jk)
                            <tr class="hover:bg-zinc-900/20 border-b border-zinc-800/50">
                                <td class="p-4">
                                    <div class="font-semibold text-zinc-200 uppercase">{{ $jk->nama_lengkap ?? $jk->name }}</div>
                                    <div class="text-[10px] text-zinc-500 font-mono mt-0.5">NIK: {{ $jk->nik ?? $jk->no_ktp ?? 'ID-'.$jk->id }}</div>
                                </td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('admin.jemaah.keluar', $jk->id) }}" method="POST" onsubmit="return confirm('Keluarkan jemaah ini dari kloter?')">
                                        @csrf
                                        <button type="submit" class="bg-red-950/40 text-red-400 border border-red-900/40 hover:bg-red-600 hover:text-white px-3 py-1 rounded-xl text-[9px] font-bold tracking-widest uppercase transition-all">
                                            ❌ Keluarkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="p-10 text-center text-zinc-600 font-bold uppercase tracking-wider">Kloter ini masih kosong, belum ada jemaah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT UNTUK PENCARIAN REAL-TIME -->
    <script>
    function cariJemaahSakti() {
        let input = document.getElementById("inputCariJemaah");
        let filter = input.value.toUpperCase();
        let rows = document.getElementsByClassName("item-jemaah-sedia");

        for (let i = 0; i < rows.length; i++) {
            let nama = rows[i].querySelector(".data-nama") ? rows[i].querySelector(".data-nama").innerText : "";
            let nik = rows[i].querySelector(".data-nik") ? rows[i].querySelector(".data-nik").innerText : "";
            let kategori = rows[i].querySelector(".data-kategori") ? rows[i].querySelector(".data-kategori").innerText : "";
            let paket = rows[i].querySelector(".data-paket") ? rows[i].querySelector(".data-paket").innerText : "";
            
            // Gabungkan seluruh data teks pada baris tersebut untuk dicocokkan
            let gabungData = (nama + " " + nik + " " + kategori + " " + paket).toUpperCase();

            if (gabungData.indexOf(filter) > -1) {
                rows[i].style.display = ""; // Tampilkan baris jika cocok
            } else {
                rows[i].style.display = "none"; // Sembunyikan jika tidak ada yang cocok
            }
        }
    }
    </script>

</body>
</html>