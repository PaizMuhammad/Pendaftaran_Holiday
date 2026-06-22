<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Holiday Angkasa Wisata</title>
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
<body class="bg-black bg-pattern min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-zinc-900/90 border border-zinc-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="font-luxury text-gold text-2xl font-bold tracking-widest uppercase">Login Jemaah</h1>
            <p class="text-zinc-500 text-[10px] tracking-[0.2em] uppercase mt-2">Holiday Angkasa Wisata</p>
            <div class="h-[1px] w-16 bg-gold/40 mx-auto mt-4"></div>
        </div>

        <!-- Notifikasi Sukses Setelah Daftar -->
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 p-3 rounded-lg mb-6 text-xs font-bold text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error Login -->
        @if(session('loginError'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-3 rounded-lg mb-6 text-xs font-bold text-center">
                {{ session('loginError') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="text-zinc-500 text-[10px] font-bold tracking-widest block mb-2 uppercase">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-600">
                        <i class="fas fa-user text-xs"></i>
                    </span>
                    <input type="text" name="username" class="w-full pl-10 p-3 bg-black text-white border border-zinc-700 rounded-xl focus:border-gold outline-none text-sm transition-all" placeholder="Masukkan username" required>
                </div>
            </div>

            <div>
                <label class="text-zinc-500 text-[10px] font-bold tracking-widest block mb-2 uppercase">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-zinc-600">
                        <i class="fas fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" class="w-full pl-10 p-3 bg-black text-white border border-zinc-700 rounded-xl focus:border-gold outline-none text-sm transition-all" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-gold text-black font-extrabold py-3 rounded-xl hover:bg-yellow-600 active:scale-[0.98] transition-all tracking-[0.2em] shadow-lg shadow-gold/20 text-xs uppercase mt-4">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-zinc-800 text-center">
            <p class="text-zinc-500 text-[10px] tracking-wide uppercase">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="text-gold font-bold hover:underline ml-1">Daftar Sekarang</a>
            </p>
        </div>
    </div>

</body>
</html>