<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortoVest - Investasi Cerdas untuk Masa Depan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#3B82F6', 'primary-dark': '#2563EB',
                        secondary: '#10B981', danger: '#EF4444',
                        dark: '#111827', light: '#F9FAFB',
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-white text-dark font-sans flex flex-col min-h-screen">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-primary flex items-center gap-2">
                PortoVest
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-gray-600 hover:text-primary transition">Fitur</a>
                <a href="#market" class="text-gray-600 hover:text-primary transition">Pasar</a>

                <a id="nav-link-pricing" href="#pricing" class="text-gray-600 hover:text-primary transition">Harga</a>

                <div id="nav-buttons" class="flex items-center">
                    <a id="btn-login" href="/login" class="hidden bg-primary text-white font-semibold py-2 px-5 rounded-lg hover:bg-primary-dark transition">
                        Masuk
                    </a>
                    <a id="btn-dashboard" href="/dashboard" class="hidden bg-blue-100 text-primary font-bold py-2 px-5 rounded-lg hover:bg-blue-200 transition flex items-center gap-2">
                        Dashboard Asset <span class="text-lg">&rarr;</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow">

        <section id="home" class="bg-light relative overflow-hidden">
            <div class="container mx-auto px-6 py-24 md:py-32 text-center relative z-10">
                <h1 class="text-4xl md:text-6xl font-bold text-dark leading-tight mb-4">
                    Monitor Seluruh Aset Investasi <br/>di Satu Tempat
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Hubungkan akun sekuritas, reksa dana, kripto, dan lainnya. PortoVest memberikan Anda gambaran lengkap dan analisis mendalam untuk keputusan investasi yang lebih baik.
                </p>

                <div id="hero-buttons">
                    <a id="btn-hero-register" href="/register" class="hidden bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-primary-dark transition text-lg shadow-lg shadow-blue-500/30">
                        Mulai Gratis Sekarang
                    </a>
                    <a id="btn-hero-dashboard" href="/dashboard" class="hidden bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-primary-dark transition text-lg shadow-lg shadow-blue-500/30">
                        Buka Dashboard Saya
                    </a>
                </div>

            </div>
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-0 opacity-30">
                <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-200 rounded-full blur-3xl mix-blend-multiply"></div>
                <div class="absolute top-40 right-0 w-96 h-96 bg-green-200 rounded-full blur-3xl mix-blend-multiply"></div>
            </div>
        </section>

        <section id="market" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-dark">Pantau Pasar Global</h2>
                    <p class="text-gray-500">Data Real-time Kripto & Saham</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">🔥 Kripto Trending</h3>
                        <div id="crypto-data-container" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <p class="text-gray-400 text-sm animate-pulse">Memuat data kripto...</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">📈 Top Gainers (US)</h3>
                        <div id="stock-data-container" class="space-y-3">
                            <p class="text-gray-400 text-sm animate-pulse">Memuat data saham...</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="py-20 bg-light">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-dark">Fitur Unggulan PortoVest</h2>
                    <p class="text-gray-600 mt-2">Semua yang Anda butuhkan untuk mengoptimalkan portofolio.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6 text-blue-600 text-2xl">📊</div>
                        <h3 class="text-xl font-bold mb-3 text-dark">Dasbor Terintegrasi</h3>
                        <p class="text-gray-600 leading-relaxed">Lihat performa saham, reksa dana, obligasi, dan aset kripto dalam satu tampilan yang intuitif.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6 text-green-600 text-2xl">📈</div>
                        <h3 class="text-xl font-bold mb-3 text-dark">Analisis Portofolio</h3>
                        <p class="text-gray-600 leading-relaxed">Dapatkan wawasan tentang alokasi aset, tingkat risiko, dan diversifikasi portofolio Anda.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6 text-yellow-600 text-2xl">💰</div>
                        <h3 class="text-xl font-bold mb-3 text-dark">Pelacakan Dividen</h3>
                        <p class="text-gray-600 leading-relaxed">Jangan lewatkan pendapatan pasif Anda. Kami melacak dan memproyeksikan dividen secara otomatis.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="pricing" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-dark">Pilihan Paket yang Fleksibel</h2>
                    <p class="text-gray-600 mt-2">Pilih paket yang paling sesuai dengan perjalanan investasi Anda.</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8 max-w-5xl mx-auto items-center">
                    <div class="border border-gray-200 rounded-2xl p-8 text-center hover:border-blue-300 transition h-full flex flex-col">
                        <h3 class="text-2xl font-bold mb-2">Basic</h3>
                        <p class="text-gray-500 mb-6 text-sm">Untuk investor pemula</p>
                        <p class="text-4xl font-bold mb-6 text-dark">Gratis</p>
                        <ul class="text-left space-y-3 mb-8 flex-grow text-gray-600">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Hingga 2 akun terhubung</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Pelacakan portofolio dasar</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Grafik performa standar</li>
                        </ul>
                        <a href="/register" class="mt-auto block w-full bg-gray-100 text-dark font-semibold py-3 rounded-xl hover:bg-gray-200 transition">Pilih Paket</a>
                    </div>
                    <div class="border-2 border-primary rounded-2xl p-8 text-center relative shadow-xl transform scale-105 bg-white z-10 flex flex-col h-full">
                        <span class="bg-primary text-white text-xs font-bold px-4 py-1 rounded-full absolute -top-3 left-1/2 -translate-x-1/2 shadow-md">Paling Populer</span>
                        <h3 class="text-2xl font-bold mb-2 text-primary">Pro</h3>
                        <p class="text-gray-500 mb-6 text-sm">Untuk investor serius</p>
                        <p class="text-4xl font-bold mb-6 text-dark">Rp 75.000<span class="text-base font-normal text-gray-500">/bulan</span></p>
                        <ul class="text-left space-y-3 mb-8 flex-grow text-gray-700">
                            <li class="flex items-center"><span class="text-primary mr-2">✓</span> <strong>Akun terhubung tak terbatas</strong></li>
                            <li class="flex items-center"><span class="text-primary mr-2">✓</span> Analisis portofolio mendalam</li>
                            <li class="flex items-center"><span class="text-primary mr-2">✓</span> Pelacakan dividen otomatis</li>
                            <li class="flex items-center"><span class="text-primary mr-2">✓</span> Laporan pajak</li>
                        </ul>
                        <a href="/register" class="mt-auto block w-full bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primary-dark transition shadow-lg shadow-blue-500/30">Pilih Paket</a>
                    </div>
                    <div class="border border-gray-200 rounded-2xl p-8 text-center hover:border-blue-300 transition h-full flex flex-col">
                        <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                        <p class="text-gray-500 mb-6 text-sm">Untuk profesional & tim</p>
                        <p class="text-4xl font-bold mb-6 text-dark">Kustom</p>
                        <ul class="text-left space-y-3 mb-8 flex-grow text-gray-600">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Semua fitur Pro</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Akses API</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Dukungan prioritas</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Dasbor kustom</li>
                        </ul>
                        <a href="#" class="mt-auto block w-full bg-gray-100 text-dark font-semibold py-3 rounded-xl hover:bg-gray-200 transition">Hubungi Sales</a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-dark text-white py-10">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-4">PortoVest</h2>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">Platform manajemen investasi terpercaya untuk memantau aset Anda di berbagai instrumen pasar.</p>
            <p class="text-sm text-gray-500">&copy; 2025 PortoVest. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. CEK TOKEN (LOGIN CHECK)
            const token = localStorage.getItem('token');
            const navLogin = document.getElementById('btn-login');
            const navDashboard = document.getElementById('btn-dashboard');
            const heroRegister = document.getElementById('btn-hero-register');
            const heroDashboard = document.getElementById('btn-hero-dashboard');

            // Perbaikan Selektor: ID harus 'pricing' agar sesuai href='#pricing'
            const pricingSection = document.getElementById('pricing');
            const navLinkPricing = document.getElementById('nav-link-pricing');

            if (token) {
                // SUDAH LOGIN
                if(navDashboard) navDashboard.classList.remove('hidden');
                if(heroDashboard) heroDashboard.classList.remove('hidden');

                // Hapus Bagian Pricing & Menu Harga
                if(pricingSection) pricingSection.style.display = 'none';
                if(navLinkPricing) navLinkPricing.style.display = 'none';

            } else {
                // BELUM LOGIN
                if(navLogin) navLogin.classList.remove('hidden');
                if(heroRegister) heroRegister.classList.remove('hidden');
                // Pricing tetap muncul
            }

            // 2. FETCH DATA API (Kripto & Saham)
            const formatCurrency = (num, curr) => new Intl.NumberFormat(curr==='IDR'?'id-ID':'en-US', {style:'currency', currency:curr, minimumFractionDigits:2}).format(num);

            fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,solana,binancecoin&vs_currencies=usd,idr')
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('crypto-data-container');
                    container.innerHTML = '';
                    ['bitcoin','ethereum','solana','binancecoin'].forEach(coin => {
                        if(data[coin]) {
                            container.innerHTML += `
                                <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm flex justify-between items-center fade-in">
                                    <span class="font-bold capitalize text-gray-700">${coin}</span>
                                    <div class="text-right">
                                        <p class="font-bold text-primary text-sm">${formatCurrency(data[coin].usd, 'USD')}</p>
                                        <p class="text-xs text-gray-400">${formatCurrency(data[coin].idr, 'IDR')}</p>
                                    </div>
                                </div>`;
                        }
                    });
                })
                .catch(() => {
                    document.getElementById('crypto-data-container').innerHTML = '<p class="text-red-400 text-xs">Gagal memuat data kripto.</p>';
                });

            fetch('https://www.alphavantage.co/query?function=TOP_GAINERS_LOSERS&apikey=demo')
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('stock-data-container');
                    if(data.top_gainers){
                        container.innerHTML = '';
                        data.top_gainers.slice(0,3).forEach(s => {
                            container.innerHTML += `
                                <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm flex justify-between items-center fade-in">
                                    <div>
                                        <span class="font-bold text-dark block">${s.ticker}</span>
                                        <span class="text-xs text-gray-500">Vol: ${s.volume}</span>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-dark text-sm">$${parseFloat(s.price).toFixed(2)}</p>
                                        <p class="text-xs font-bold text-secondary">+${s.change_percentage}</p>
                                    </div>
                                </div>`;
                        });
                    }
                })
                .catch(() => {
                    document.getElementById('stock-data-container').innerHTML = '<p class="text-yellow-600 bg-yellow-50 p-2 rounded text-xs">API Limit (Demo Mode)</p>';
                });
        });
    </script>
</body>
</html>
