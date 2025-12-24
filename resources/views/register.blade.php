<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PortoVest</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 flex items-center justify-center h-screen text-white">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96 border border-gray-700">
        <h1 class="text-3xl font-bold text-center mb-6 text-green-500">Register</h1>

        <form id="registerForm" class="space-y-4">
            <div>
                <label class="block text-sm mb-1 text-gray-400">Nama Lengkap</label>
                <input type="text" id="name" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-green-500" required>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-400">Email Address</label>
                <input type="email" id="email" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-green-500" required>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-400">Password</label>
                <input type="password" id="password" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-green-500" required>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 py-3 rounded font-bold transition">DAFTAR SEKARANG</button>
        </form>

        <p class="mt-4 text-center text-gray-400 text-sm">
            Sudah punya akun? <a href="/login" class="text-blue-400 hover:underline">Login disini</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Ambil data form
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                // Tembak API Register
                await axios.post('/api/register', {
                    name: name,
                    email: email,
                    password: password
                });

                // Jika sukses
                alert('Registrasi Berhasil! Silakan Login.');
                window.location.href = '/login';

            } catch (error) {
                console.error(error);
                // Cek error validasi dari Laravel
                if (error.response && error.response.data.message) {
                    alert('Gagal: ' + error.response.data.message);
                } else {
                    alert('Terjadi kesalahan sistem.');
                }
            }
        });
    </script>
</body>
</html>
