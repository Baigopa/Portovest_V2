<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PortoVest</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 flex items-center justify-center h-screen text-white">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96 border border-gray-700">
        <h1 class="text-3xl font-bold text-center mb-6 text-blue-500">PortoVest</h1>

        <form id="loginForm" class="space-y-4">
            <input type="email" id="email" placeholder="Email" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-blue-500" required>
            <input type="password" id="password" placeholder="Password" class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:border-blue-500" required>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3 rounded font-bold transition">LOGIN</button>
        </form>

        <p class="mt-4 text-center text-gray-400 text-sm">
            Belum punya akun? <a href="/register" class="text-blue-400 hover:underline">Daftar disini</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const res = await axios.post('/api/login', {
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value
                });
                localStorage.setItem('token', res.data.access_token);
                window.location.href = '/dashboard';
            } catch (err) {
                alert('Login Gagal! Cek email/password.');
            }
        });
    </script>
</body>
</html>
