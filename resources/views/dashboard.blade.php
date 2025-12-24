<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PortoVest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">

    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <a href="/" class="text-gray-400 hover:text-blue-600 transition duration-300" title="Kembali ke Halaman Depan">
                <i class="fa-solid fa-home text-xl"></i>
            </a>

            <a href="/dashboard" class="text-2xl font-bold text-blue-600 flex items-center gap-2 hover:opacity-80 transition">
                PortoVest <span class="text-gray-400 text-lg font-normal">Dashboard</span>
            </a>
        </div>

        <button onclick="logout()" class="text-red-500 font-semibold hover:bg-red-50 px-4 py-2 rounded transition border border-transparent hover:border-red-100">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
        </button>
    </nav>

    <div class="container mx-auto mt-8 p-6">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Portofolio Aset Saya</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola semua investasi Anda di sini.</p>
            </div>
            <button onclick="openModal('create')" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus"></i> Tambah Aset
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b border-gray-200">
                            <th class="p-4">Logo</th>
                            <th class="p-4">Nama Aset</th>
                            <th class="p-4 text-center">Tipe</th>
                            <th class="p-4 text-right">Harga Beli</th>
                            <th class="p-4 text-center">Qty</th>
                            <th class="p-4 text-right">Total Nilai</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="assetTable" class="text-sm divide-y divide-gray-100">
                        <tr><td colspan="7" class="p-8 text-center text-gray-400">Sedang memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="assetModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 border-b pb-2 mb-4" id="modalTitle">Tambah Aset Baru</h3>
                    <form id="assetForm" class="space-y-4">
                        <input type="hidden" id="assetId">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Aset</label>
                            <input type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Bitcoin, BBCA" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                                <select id="asset_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border bg-white">
                                    <option value="stock">Saham (Stock)</option>
                                    <option value="crypto">Kripto</option>
                                    <option value="mf">Reksa Dana</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Beli</label>
                                <input type="date" id="purchase_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Beli (Rp)</label>
                                <input type="number" id="purchase_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" placeholder="0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah (Qty)</label>
                                <input type="number" step="0.0001" id="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" placeholder="0" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Logo Aset</label>
                            <input type="file" id="logo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">*Maks 5MB. Kosongkan jika edit dan tidak ingin ubah logo.</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" onclick="saveAsset()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div id="sellModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeSellModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-yellow-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fa-solid fa-money-bill-wave text-yellow-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Jual Aset</h3>
                            <div class="mt-2 space-y-3">
                                <p class="text-sm text-gray-500">Anda akan menjual aset <strong id="sellAssetName" class="text-gray-800">...</strong></p>
                                <p class="text-xs text-gray-400 mt-1">Sisa Stok Saat Ini: <span id="sellCurrentStock" class="font-mono font-bold">0</span></p>

                                <form id="sellForm" class="mt-4 space-y-3">
                                    <input type="hidden" id="sellAssetId">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 text-left">Jumlah Lembar/Lot yang dijual:</label>
                                        <input type="number" step="0.0001" id="sellAmount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-yellow-500 focus:border-yellow-500" placeholder="0" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 text-left">Harga Jual per Lembar (Rp):</label>
                                        <input type="number" id="sellPrice" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-yellow-500 focus:border-yellow-500" placeholder="Masukkan harga jual" required>
                                        <p class="text-xs text-gray-500 mt-1 text-left bg-green-50 p-2 rounded border border-green-100">
                                            Total Uang Diterima: <span id="totalEstimation" class="font-bold text-green-700 text-sm">Rp 0</span>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" onclick="confirmSell()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Konfirmasi Jual
                    </button>
                    <button type="button" onclick="closeSellModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        // --- 1. LOAD DATA ---
        async function loadData() {
            try {
                const res = await axios.get('/api/assets', { headers: { Authorization: `Bearer ${token}` } });
                const tableBody = document.getElementById('assetTable');

                if(res.data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="7" class="p-8 text-center text-gray-500">Belum ada aset. Klik tombol Tambah di atas.</td></tr>`;
                    return;
                }

                tableBody.innerHTML = res.data.map(item => {
                    const total = item.purchase_price * item.quantity;
                    return `
                    <tr class="hover:bg-blue-50 transition group border-b border-gray-50">
                        <td class="p-4"><img src="${item.logo_url}" class="w-10 h-10 rounded-full object-cover border bg-white shadow-sm"></td>
                        <td class="p-4 font-semibold text-gray-700">${item.name}</td>
                        <td class="p-4 text-center"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold uppercase tracking-wide">${item.asset_type}</span></td>
                        <td class="p-4 text-right font-mono text-gray-600">Rp ${new Intl.NumberFormat('id-ID').format(item.purchase_price)}</td>
                        <td class="p-4 text-center font-mono">${item.quantity}</td>
                        <td class="p-4 text-right font-mono font-bold text-gray-800">Rp ${new Intl.NumberFormat('id-ID').format(total)}</td>
                        <td class="p-4 text-center whitespace-nowrap">

                            <button onclick="openSellModal(${item.id}, '${item.name}', ${item.quantity})" class="text-green-500 hover:text-green-700 hover:bg-green-50 p-2 rounded transition mr-1" title="Jual Aset">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </button>

                            <button onclick="editAsset(${item.id})" class="text-yellow-500 hover:text-yellow-700 hover:bg-yellow-50 p-2 rounded transition mr-1" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <button onclick="deleteAsset(${item.id})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                }).join('');
            } catch (err) {
                console.error(err);
                if(err.response && err.response.status === 401) logout();
            }
        }

        // --- 2. LOGIKA CREATE & EDIT (Semua pakai ID) ---
        function openModal(mode, data = null) {
            document.getElementById('assetModal').classList.remove('hidden');
            const form = document.getElementById('assetForm');
            const title = document.getElementById('modalTitle');

            if (mode === 'create') {
                title.innerText = "Tambah Aset Baru";
                document.getElementById('assetId').value = '';
                form.reset();
            } else {
                title.innerText = "Edit Aset";
                // GUNAKAN ID ANGKA
                document.getElementById('assetId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('asset_type').value = data.asset_type;
                document.getElementById('purchase_price').value = data.purchase_price;
                document.getElementById('quantity').value = data.quantity;
                document.getElementById('purchase_date').value = data.purchase_date;
            }
        }

        function closeModal() {
            document.getElementById('assetModal').classList.add('hidden');
        }

        async function saveAsset() {
            const id = document.getElementById('assetId').value;
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('asset_type', document.getElementById('asset_type').value);
            formData.append('purchase_price', document.getElementById('purchase_price').value);
            formData.append('quantity', document.getElementById('quantity').value);
            formData.append('purchase_date', document.getElementById('purchase_date').value);

            const logoFile = document.getElementById('logo').files[0];
            if (logoFile) {
                formData.append('logo', logoFile);
            }

            try {
                let url = '/api/assets';
                if (id) {
                    url += `/${id}`; // URL: /api/assets/8
                    formData.append('_method', 'POST');
                }

                await axios.post(url, formData, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'multipart/form-data' }
                });

                closeModal();
                loadData();
                Swal.fire('Berhasil!', 'Data aset berhasil disimpan.', 'success');
            } catch (error) {
                let msg = 'Gagal menyimpan data.';
                if(error.response && error.response.data.message) msg = error.response.data.message;
                Swal.fire('Error!', msg, 'error');
            }
        }

        // EDIT (Pakai ID)
        async function editAsset(id) {
            try {
                const res = await axios.get(`/api/assets/${id}`, { headers: { Authorization: `Bearer ${token}` } });
                openModal('edit', res.data);
            } catch (error) {
                Swal.fire('Error', 'Gagal mengambil data aset', 'error');
            }
        }

        // HAPUS (Pakai ID)
        async function deleteAsset(id) {
            const result = await Swal.fire({
                title: 'Yakin hapus?', text: "Data tidak bisa dikembalikan!", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!'
            });

            if (result.isConfirmed) {
                try {
                    await axios.delete(`/api/assets/${id}`, { headers: { Authorization: `Bearer ${token}` } });
                    loadData();
                    Swal.fire('Terhapus!', 'Aset berhasil dihapus.', 'success');
                } catch (error) {
                    Swal.fire('Gagal!', 'Gagal menghapus aset.', 'error');
                }
            }
        }

        // --- 4. LOGIKA JUAL ASET ---
        function openSellModal(id, name, stock) {
            document.getElementById('sellModal').classList.remove('hidden');
            document.getElementById('sellAssetId').value = id;
            document.getElementById('sellAssetName').innerText = name;
            document.getElementById('sellCurrentStock').innerText = stock;

            document.getElementById('sellAmount').value = '';
            document.getElementById('sellPrice').value = '';
            document.getElementById('totalEstimation').innerText = 'Rp 0';
        }

        function closeSellModal() {
            document.getElementById('sellModal').classList.add('hidden');
        }

        // Hitung Otomatis
        ['sellAmount', 'sellPrice'].forEach(elemId => {
            const elem = document.getElementById(elemId);
            if(elem){
                elem.addEventListener('input', function() {
                    const amount = document.getElementById('sellAmount').value || 0;
                    const price = document.getElementById('sellPrice').value || 0;
                    const total = amount * price;
                    document.getElementById('totalEstimation').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
                });
            }
        });

        async function confirmSell() {
            const id = document.getElementById('sellAssetId').value;
            const amount = document.getElementById('sellAmount').value;
            const price = document.getElementById('sellPrice').value;

            if(!amount || amount <= 0 || !price || price < 0) {
                Swal.fire('Peringatan', 'Mohon isi jumlah dan harga dengan benar!', 'warning');
                return;
            }

            try {
                // Panggil API Transaction
                const response = await axios.post('/api/transactions', {
                    asset_id: id,
                    type: 'sell',
                    amount: amount,
                    price: price
                }, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                closeSellModal();
                loadData();

                const totalUang = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.data.total_uang);
                Swal.fire('Berhasil!', `Terjual! Anda mendapatkan: ${totalUang}`, 'success');

            } catch (error) {
                console.error(error);
                let msg = 'Transaksi Gagal.';
                if(error.response && error.response.data.error) msg = error.response.data.error;
                if(error.response && error.response.data.message) msg = error.response.data.message;
                Swal.fire('Gagal!', msg, 'error');
            }
        }

        async function logout() {
            try { await axios.post('/api/logout', {}, { headers: { Authorization: `Bearer ${token}` } }); } catch(e){}
            localStorage.removeItem('token');
            window.location.href = '/';
        }

        loadData();
    </script>
</body>
</html>
