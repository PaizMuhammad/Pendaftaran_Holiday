<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Holiday Angkasa Wisata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-luxury { font-family: 'Cinzel', serif; }
        .bg-gold { background-color: #D4AF37; }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .hover-gold:hover { background-color: #B8962E; }
        .bg-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
        }
    </style>
</head>
<body class="bg-black bg-pattern min-h-screen flex items-center justify-center p-4">

    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-800">
        
        <div class="hidden md:flex md:w-2/5 relative bg-zinc-800 items-center justify-center overflow-hidden border-r border-zinc-800">
            <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-20 shadow-inner">
            
            <div class="absolute inset-0 bg-gradient-to-br from-black via-zinc-900/90 to-gold/10 opacity-90"></div>
            
            <div class="relative z-10 p-10 text-left">
                <h1 class="font-luxury text-gold text-2xl font-bold mb-6 tracking-widest uppercase">Mulai Niat Suci Anda</h1>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="text-gold mt-1"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <p class="text-white font-bold text-sm">Pendaftaran Cepat</p>
                            <p class="text-zinc-400 text-xs mt-1">Proses registrasi akun hanya dalam hitungan menit.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="text-gold mt-1"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <p class="text-white font-bold text-sm">Data Aman & Terenkripsi</p>
                            <p class="text-zinc-400 text-xs mt-1">Kami menjamin kerahasiaan data pribadi calon jamaah.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="text-gold mt-1"><i class="fas fa-headset"></i></div>
                        <div>
                            <p class="text-white font-bold text-sm">Bantuan 24/7</p>
                            <p class="text-zinc-400 text-xs mt-1">Tim IT & Operasional siap membantu kendala teknis pendaftaran.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 p-4 border border-gold/20 bg-gold/5 rounded-xl">
                    <p class="text-gold text-[10px] tracking-widest uppercase mb-1">Butuh Bantuan?</p>
                    <p class="text-zinc-300 text-xs font-semibold italic underline decoration-gold">Hubungi CS Holiday Angkasa</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-3/5 p-8 lg:p-12 flex flex-col justify-center bg-zinc-900/80 backdrop-blur-md">
            <div class="mb-8 text-center md:text-left">
                <h2 class="text-white text-2xl font-bold tracking-tight mb-1 font-luxury uppercase tracking-widest text-gold">Daftar Akun Baru</h2>
                <p class="text-zinc-500 text-sm">Lengkapi data di bawah ini untuk memulai pendaftaran Haji & Umroh</p>
            </div>

            <!-- BAGIAN UPDATE: TAMPILAN ERROR VALIDASI -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-900/20 border border-red-500/50 rounded-xl">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2 shadow-sm"></i>
                        <span class="text-red-500 text-[11px] font-bold uppercase tracking-wider">Terjadi Kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-zinc-300 text-[10px] italic">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf
                
                <div class="md:col-span-2">
                    <label class="text-gold text-[10px] font-bold tracking-[0.2em] block mb-2 uppercase">NAMA LENGKAP (Sesuai KTP)</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-600 group-focus-within:text-gold transition-colors">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full pl-12 pr-4 py-3 bg-black text-white border border-zinc-800 rounded-xl focus:border-gold focus:ring-1 focus:ring-gold outline-none text-sm transition-all shadow-inner" 
                            placeholder="Contoh: Muhammad Ali" required>
                    </div>
                </div>

                <div>
                    <label class="text-gold text-[10px] font-bold tracking-[0.2em] block mb-2 uppercase">USERNAME</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-600 group-focus-within:text-gold transition-colors">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="w-full pl-12 pr-4 py-3 bg-black text-white border border-zinc-800 rounded-xl focus:border-gold focus:ring-1 focus:ring-gold outline-none text-sm transition-all shadow-inner" 
                            placeholder="username123" required>
                    </div>
                </div>

                <div>
                    <label class="text-gold text-[10px] font-bold tracking-[0.2em] block mb-2 uppercase">ALAMAT EMAIL</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-600 group-focus-within:text-gold transition-colors">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-3 bg-black text-white border border-zinc-800 rounded-xl focus:border-gold focus:ring-1 focus:ring-gold outline-none text-sm transition-all shadow-inner" 
                            placeholder="nama@email.com" required>
                    </div>
                </div>

                <div>
                    <label class="text-gold text-[10px] font-bold tracking-[0.2em] block mb-2 uppercase">PASSWORD</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-600 group-focus-within:text-gold transition-colors">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" 
                            class="w-full pl-12 pr-4 py-3 bg-black text-white border border-zinc-800 rounded-xl focus:border-gold focus:ring-1 focus:ring-gold outline-none text-sm transition-all shadow-inner" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div>
                    <label class="text-gold text-[10px] font-bold tracking-[0.2em] block mb-2 uppercase">KONFIRMASI PASSWORD</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-600 group-focus-within:text-gold transition-colors">
                            <i class="fas fa-shield-check"></i>
                        </span>
                        <input type="password" name="password_confirmation" 
                            class="w-full pl-12 pr-4 py-3 bg-black text-white border border-zinc-800 rounded-xl focus:border-gold focus:ring-1 focus:ring-gold outline-none text-sm transition-all shadow-inner" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="md:col-span-2 pt-4">
                    <button type="submit" 
                        class="w-full bg-gold text-black font-extrabold py-4 rounded-xl hover-gold active:scale-[0.97] transition-all transform tracking-[0.2em] shadow-lg shadow-gold/20 text-xs uppercase">
                        DAFTARKAN AKUN
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-zinc-500 text-[11px] uppercase tracking-wider">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-gold font-bold hover:underline ml-1">Masuk Kembali</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>