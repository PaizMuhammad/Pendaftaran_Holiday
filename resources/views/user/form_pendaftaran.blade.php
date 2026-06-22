<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran {{ ucfirst($kategori) }} | Holiday Angkasa Wisata</title>
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
<body class="bg-black bg-pattern min-h-screen p-4 md:p-8 text-white">

    <div class="max-w-4xl mx-auto">
        <!-- HEADER -->
        <div class="mb-10 text-center">
            <h1 class="font-luxury text-gold text-3xl font-bold tracking-widest uppercase mb-2">
                Pendaftaran {{ ucfirst($kategori) }}
            </h1>
            <p class="text-zinc-500 text-xs tracking-[0.2em] uppercase">Holiday Angkasa Wisata</p>
            <div class="h-[1px] w-24 bg-gold/40 mx-auto mt-4"></div>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-500 p-4 rounded-xl mb-6 text-xs font-bold uppercase tracking-widest">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- PERBAIKAN: Memastikan Kategori dikirim dengan Huruf Kapital depan (Umrah / Haji) -->
            <input type="hidden" name="kategori" value="{{ ucfirst($kategori) }}">

            <!-- BAGIAN PAKET (DINAMIS) -->
            <div class="bg-zinc-900/90 border border-zinc-800 p-6 rounded-2xl shadow-2xl">
                <h3 class="text-gold text-[10px] font-bold tracking-[0.3em] uppercase mb-6 flex items-center">
                    <i class="fas fa-box-open mr-2"></i> Detail Paket {{ ucfirst($kategori) }}
                </h3>
                
                <!-- PERBAIKAN: Mengecek 'umrah' (dengan huruf 'a') -->
                @if(($kategori == 'umrah' || $kategori == 'umroh') && $packages->count() > 0)
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <select name="package_id" id="package_select" onchange="updateDetailPaket()" class="w-full p-3 bg-black text-white border border-zinc-700 rounded-xl focus:border-gold outline-none text-sm" required>
                                <option value="">-- Pilih Paket Tersedia --</option>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}" 
                                            data-harga="{{ number_format($pkg->harga, 0, ',', '.') }}" 
                                            data-hotel="{{ $pkg->jarak_hotel }}"
                                            data-fasilitas="{{ $pkg->fasilitas }}">
                                        {{ $pkg->nama_paket }} ({{ $pkg->durasi }} Hari)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="price_card" class="hidden bg-zinc-800/50 border border-gold/20 p-6 rounded-xl transition-all">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <p class="text-[9px] text-gold font-bold uppercase tracking-widest mb-1">Estimasi Harga</p>
                                    <h4 class="text-2xl font-bold text-white">Rp <span id="display_price"></span></h4>
                                </div>
                                <div class="md:text-right">
                                    <p class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-1">Akomodasi / Hotel</p>
                                    <p class="text-sm text-zinc-300 font-bold"><i class="fas fa-hotel mr-2 text-gold"></i><span id="display_hotel"></span></p>
                                </div>
                            </div>
                            <div class="border-t border-zinc-700 pt-4">
                                <p class="text-[9px] text-zinc-500 font-bold uppercase tracking-widest mb-3">Fasilitas Utama</p>
                                <div id="display_fasilitas" class="text-[11px] text-zinc-400 grid grid-cols-1 md:grid-cols-2 gap-2 italic"></div>
                            </div>
                        </div>
                    </div>
                @elseif($kategori == 'haji')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-black/50 border border-zinc-800 p-4 rounded-xl text-center">
                            <i class="fas fa-crown text-gold text-2xl mb-3"></i>
                            <h4 class="text-[10px] font-bold text-gold uppercase tracking-widest mb-2">Haji Tanpa Antre</h4>
                            <p class="text-[10px] text-zinc-400">Pendaftaran langsung diproses melalui kuota khusus (Furoda/Plus).</p>
                        </div>
                        <div class="bg-black/50 border border-zinc-800 p-4 rounded-xl text-center">
                            <i class="fas fa-star text-gold text-2xl mb-3"></i>
                            <h4 class="text-[10px] font-bold text-gold uppercase tracking-widest mb-2">Layanan Premium</h4>
                            <p class="text-[10px] text-zinc-400">Akomodasi hotel bintang 5 dengan jarak terdekat ke Masjidil Haram.</p>
                        </div>
                        <div class="bg-black/50 border border-zinc-800 p-4 rounded-xl text-center">
                            <i class="fas fa-kaaba text-gold text-2xl mb-3"></i>
                            <h4 class="text-[10px] font-bold text-gold uppercase tracking-widest mb-2">Pembimbing Ahli</h4>
                            <p class="text-[10px] text-zinc-400">Dibimbing oleh Muthawif berpengalaman sesuai tuntunan Sunnah.</p>
                        </div>
                        <div class="md:col-span-3 mt-2">
                            <div class="bg-gold/5 border border-gold/20 p-3 rounded-lg text-center">
                                <p class="text-[11px] text-zinc-300 italic">"Pilihan paket detail akan dikonfirmasi oleh Admin setelah pendaftaran dilakukan."</p>
                            </div>
                        </div>
                    </div>
                    <!-- PERBAIKAN: Default value 0 agar tidak Null error -->
                    <input type="hidden" name="package_id" value="0">
                @else
                    <div class="text-center py-4">
                        <p class="text-sm text-zinc-400 italic">Silakan lanjutkan pendaftaran umum.</p>
                        <input type="hidden" name="package_id" value="0">
                    </div>
                @endif
            </div>

            <!-- DATA DIRI -->
            <div class="bg-zinc-900/90 border border-zinc-800 p-6 rounded-2xl shadow-2xl">
                <h3 class="text-gold text-[10px] font-bold tracking-[0.3em] uppercase mb-6 flex items-center">
                    <i class="fas fa-user-edit mr-2"></i> Data Diri Jemaah
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest mb-2 block">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full p-3 bg-black border border-zinc-700 rounded-xl focus:border-gold outline-none text-sm" placeholder="Sesuai KTP" required>
                    </div>
                    <div>
                        <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest mb-2 block">NIK</label>
                        <input type="number" name="nik" value="{{ old('nik') }}" class="w-full p-3 bg-black border border-zinc-700 rounded-xl focus:border-gold outline-none text-sm" placeholder="16 Digit NIK" required>
                    </div>
                    <div>
                        <label class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest mb-2 block">No. WhatsApp</label>
                        <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" class="w-full p-3 bg-black border border-zinc-700 rounded-xl focus:border-gold outline-none text-sm" placeholder="08xx..." required>
                    </div>
                </div>
            </div>

            <!-- BERKAS -->
            <div class="bg-zinc-900/90 border border-zinc-800 p-6 rounded-2xl shadow-2xl">
                <h3 class="text-gold text-[10px] font-bold tracking-[0.3em] uppercase mb-6 flex items-center">
                    <i class="fas fa-file-upload mr-2"></i> Berkas Pendukung
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <p class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest">Foto KTP</p>
                        <input type="file" name="foto_ktp" class="w-full text-xs text-zinc-400 file:bg-zinc-800 file:text-gold file:border-0 file:rounded-lg file:px-4 file:py-2" required>
                    </div>
                    <div class="space-y-2">
                        <p class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest">Foto KK</p>
                        <input type="file" name="foto_kk" class="w-full text-xs text-zinc-400 file:bg-zinc-800 file:text-gold file:border-0 file:rounded-lg file:px-4 file:py-2" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-gold text-black font-black py-4 rounded-xl hover:bg-yellow-600 transition-all tracking-[0.2em] uppercase text-xs">
                Kirim Pendaftaran {{ ucfirst($kategori) }}
            </button>
        </form>
    </div>

    <script>
        function updateDetailPaket() {
            const select = document.getElementById('package_select');
            const card = document.getElementById('price_card');
            const priceVal = document.getElementById('display_price');
            const hotelVal = document.getElementById('display_hotel');
            const fasilitasDiv = document.getElementById('display_fasilitas');

            if (!select) return;

            const selected = select.options[select.selectedIndex];
            
            if(select.value !== "") {
                card.classList.remove('hidden');
                priceVal.innerText = selected.getAttribute('data-harga');
                hotelVal.innerText = selected.getAttribute('data-hotel');

                const fasilitas = selected.getAttribute('data-fasilitas');
                const listFasilitas = fasilitas ? fasilitas.split('\n') : [];
                fasilitasDiv.innerHTML = ''; 
                listFasilitas.forEach(item => {
                    if(item.trim() !== "") {
                        fasilitasDiv.innerHTML += `<span><i class="fas fa-check text-gold mr-2"></i>${item.replace('- ', '')}</span>`;
                    }
                });
            } else {
                card.classList.add('hidden');
            }
        }
    </script>
</body>
</html>