<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PortoVest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 h-screen flex justify-center items-center">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-100">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">PortoVest</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk untuk mengelola aset Anda</p>
        </div>

        <form id="loginForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500" placeholder="nama@email.com" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun? <a href="/register" class="text-blue-600 font-semibold hover:underline">Daftar di sini</a>
        </p>
        <p class="text-center text-sm mt-2">
            <a href="/" class="text-gray-400 hover:text-gray-600">&larr; Kembali ke Beranda</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Cek kalau sudah login, langsung lempar ke dashboard
        if(localStorage.getItem('token')) {
            window.location.href = '/dashboard';
        }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Mencegah reload halaman

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Tampilkan Loading
            Swal.fire({ title: 'Sedang memproses...', didOpen: () => { Swal.showLoading() } });

            try {
                // 1. Request ke API Login
                const response = await axios.post('/api/login', {
                    email: email,
                    password: password
                });

                // 2. SIMPAN TOKEN KE BROWSER (Ini Bagian Paling Penting!)
                // Pastikan AuthController Anda mengembalikan JSON berisi 'token'
                const token = response.data.token;
                localStorage.setItem('token', token);

                // 3. Beri Notifikasi Sukses
                await Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Masuk!',
                    text: 'Mengalihkan ke dashboard...',
                    timer: 1500,
                    showConfirmButton: false
                });

                // 4. PINDAH KE HALAMAN DASHBOARD
                window.location.href = '/dashboard';

            } catch (error) {
                console.error(error);
                let msg = 'Email atau password salah.';
                if(error.response && error.response.data.message) {
                    msg = error.response.data.message;
                }
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    </script>
</body>
</html>
