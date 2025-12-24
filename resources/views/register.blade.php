<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PortoVest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 h-screen flex justify-center items-center">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-100">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">PortoVest</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk memulai investasi</p>
        </div>

        <form id="registerForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500" placeholder="Jhon Doe" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500" placeholder="nama@email.com" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm p-3 border focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-md hover:shadow-lg">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun? <a href="/login" class="text-blue-600 font-semibold hover:underline">Masuk di sini</a>
        </p>
        <p class="text-center text-sm mt-2">
            <a href="/" class="text-gray-400 hover:text-gray-600">&larr; Kembali ke Beranda</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Cek kalau sudah login, jangan boleh daftar lagi, lempar ke dashboard
        if(localStorage.getItem('token')) {
            window.location.href = '/dashboard';
        }

        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Mencegah reload halaman

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Tampilkan Loading
            Swal.fire({ title: 'Sedang memproses...', didOpen: () => { Swal.showLoading() } });

            try {
                // 1. Request ke API Register
                const response = await axios.post('/api/register', {
                    name: name,
                    email: email,
                    password: password
                });

                // 2. CEK APAKAH DAPAT TOKEN LANGSUNG? (AUTO LOGIN)
                if (response.data.access_token || response.data.token) {
                    const token = response.data.access_token || response.data.token;
                    localStorage.setItem('token', token);

                    await Swal.fire({
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        text: 'Anda akan dialihkan ke dashboard...',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    window.location.href = '/dashboard';
                } else {
                    // Jika backend hanya return "Success" tanpa token, suruh login manual
                    await Swal.fire({
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        text: 'Silakan masuk dengan akun baru Anda.',
                        confirmButtonText: 'Ke Halaman Login'
                    });
                    window.location.href = '/login';
                }

            } catch (error) {
                console.error(error);
                let msg = 'Gagal mendaftar.';
                if(error.response && error.response.data.message) {
                    msg = error.response.data.message;
                }
                // Jika error validasi Laravel (misal email sudah ada)
                if(error.response && error.response.data.errors) {
                    msg = Object.values(error.response.data.errors).flat().join('\n');
                }
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    </script>
</body>
</html>
