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
        /* Animasi kedip untuk harga update */
        @keyframes flashGreen { 0% { background-color: #dcfce7; } 100% { background-color: transparent; } }
        @keyframes flashRed { 0% { background-color: #fee2e2; } 100% { background-color: transparent; } }
        .flash-up { animation: flashGreen 1s ease-out; }
        .flash-down { animation: flashRed 1s ease-out; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800" onclick="closeDropdown(event)">

    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <a href="/" class="text-gray-400 hover:text-blue-600 transition duration-300">
                <i class="fa-solid fa-home text-xl"></i>
            </a>
            <a href="/dashboard" class="text-2xl font-bold text-blue-600 flex items-center gap-2 hover:opacity-80 transition">
                PortoVest <span class="text-gray-400 text-lg font-normal">Dashboard</span>
            </a>
        </div>
        <div class="relative">
            <button onclick="toggleProfileMenu()" class="flex items-center gap-3 focus:outline-none hover:bg-gray-50 p-2 rounded-lg transition">
                <div class="text-right hidden md:block">
                    <p id="navUserName" class="text-sm font-bold text-gray-700">Memuat...</p>
                    <p class="text-xs text-gray-500">Investor</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 border border-blue-200 shadow-sm">
                    <i class="fa-solid fa-user text-lg"></i>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
            </button>
            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 border border-gray-100 z-50 transform origin-top-right transition-all">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Sedang Login</p>
                    <p id="navUserEmail" class="text-sm font-medium text-gray-800 truncate mt-1">...</p>
                </div>
                <button onclick="logout()" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition font-medium">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                </button>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Portofolio Live Market ⚡</h2>
                <p class="text-sm text-gray-500 mt-1">Harga bergerak real-time (Simulasi).</p>
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
                            <th class="p-4">Aset</th>
                            <th class="p-4 text-center">Tipe</th>
                            <th class="p-4 text-right">Avg Price</th>
                            <th class="p-4 text-right bg-gray-50">Harga Pasar</th>
                            <th class="p-4 text-center">Gain/Loss</th>
                            <th class="p-4 text-center">Qty (Lot/Unit)</th>
                            <th class="p-4 text-right font-bold">Total Assets</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="assetTable" class="text-sm divide-y divide-gray-100">
                        <tr><td colspan="8" class="p-8 text-center text-gray-400">Sedang memuat data...</td></tr>
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
                            <input type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: GOTO, BBCA" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe</label>
                                <select id="asset_type" onchange="updateFormLabels()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border bg-white">
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
                                <label id="labelInputPrice" class="block text-sm font-medium text-gray-700">Harga Beli per Lembar (Rp)</label>
                                <input type="number" id="purchase_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" placeholder="50" required>
                            </div>
                            <div>
                                <label id="labelInputQty" class="block text-sm font-medium text-gray-700">Jumlah (Lot)</label>
                                <input type="number" step="0.0001" id="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" placeholder="Contoh: 10" required>
                                <p id="helperInputQty" class="text-xs text-gray-400 mt-1">*Input dalam Lot (Sistem otomatis kalikan 100)</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Logo Aset</label>
                            <input type="file" id="logo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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
                                <p class="text-sm text-gray-500">Aset: <strong id="sellAssetName" class="text-gray-800">...</strong></p>
                                <p class="text-xs text-gray-400 mt-1">Stok: <span id="sellCurrentStock" class="font-mono font-bold">0</span></p>
                                <form id="sellForm" class="mt-4 space-y-3">
                                    <input type="hidden" id="sellAssetId">
                                    <div>
                                        <label id="labelQty" class="block text-sm font-medium text-gray-700 text-left">Jumlah yang dijual:</label>
                                        <input type="number" step="0.0001" id="sellAmount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-yellow-500 focus:border-yellow-500" placeholder="0" required>
                                        <p id="lotConversionInfo" class="text-xs text-gray-400 mt-1 hidden text-left"></p>
                                    </div>
                                    <div>
                                        <label id="labelPrice" class="block text-sm font-medium text-gray-700 text-left">Harga Jual (Rp):</label>
                                        <input type="number" id="sellPrice" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-yellow-500 focus:border-yellow-500" placeholder="Masukkan harga" required>
                                        <p class="text-xs text-gray-500 mt-1 text-left bg-green-50 p-2 rounded border border-green-100">
                                            Total: <span id="totalEstimation" class="font-bold text-green-700 text-sm">Rp 0</span>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                    <button type="button" onclick="confirmSell()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Konfirmasi Jual</button>
                    <button type="button" onclick="closeSellModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const token = localStorage.getItem('token');
        if (!token) window.location.href = '/login';

        let currentAssetType = '';
        let liveInterval = null; // Menyimpan interval polling

        // --- 1. REALTIME LOGIC (NEW) ---
        function startLivePolling() {
            // Panggil setiap 3 detik
            if (liveInterval) clearInterval(liveInterval);
            liveInterval = setInterval(fetchLivePrices, 3000);
        }

        async function fetchLivePrices() {
            try {
                const res = await axios.get('/api/assets/live-prices', { headers: { Authorization: `Bearer ${token}` } });

                res.data.forEach(item => {
                    // Update Harga Pasar
                    const priceElem = document.getElementById(`live-price-${item.id}`);
                    const totalElem = document.getElementById(`total-value-${item.id}`);
                    const changeElem = document.getElementById(`change-${item.id}`);
                    const rowElem = document.getElementById(`row-${item.id}`);

                    if (priceElem) {
                        // Cek apakah harga naik/turun untuk efek visual
                        const oldPrice = parseInt(priceElem.dataset.value || 0);
                        const newPrice = parseInt(item.market_price);

                        if (newPrice > oldPrice) {
                            priceElem.className = "p-4 text-right bg-gray-50 font-mono font-bold text-green-600 transition duration-300";
                            rowElem.classList.add('flash-up');
                            setTimeout(() => rowElem.classList.remove('flash-up'), 1000);
                        } else if (newPrice < oldPrice) {
                            priceElem.className = "p-4 text-right bg-gray-50 font-mono font-bold text-red-600 transition duration-300";
                            rowElem.classList.add('flash-down');
                            setTimeout(() => rowElem.classList.remove('flash-down'), 1000);
                        }

                        // Update Text
                        priceElem.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(newPrice)}`;
                        priceElem.dataset.value = newPrice;

                        // Update Total Value
                        totalElem.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(item.total_value)}`;

                        // Update Gain/Loss
                        const icon = item.is_profit ? '<i class="fa-solid fa-caret-up mr-1"></i>' : '<i class="fa-solid fa-caret-down mr-1"></i>';
                        const colorClass = item.is_profit ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
                        changeElem.innerHTML = `<span class="${colorClass} px-2 py-1 rounded text-xs font-bold whitespace-nowrap">${icon} ${item.change_pct}%</span>`;
                    }
                });
            } catch (error) {
                console.error("Gagal polling live prices", error);
            }
        }

        async function loadData() {
            try {
                const res = await axios.get('/api/assets', { headers: { Authorization: `Bearer ${token}` } });
                const tableBody = document.getElementById('assetTable');

                if(res.data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="8" class="p-8 text-center text-gray-500">Belum ada aset. Klik tombol Tambah di atas.</td></tr>`;
                    return;
                }

                tableBody.innerHTML = res.data.map(item => {
                    // Default view sebelum live data masuk
                    const total = item.purchase_price * item.quantity;
                    let displayQty = parseFloat(item.quantity);
                    let unitType = 'Unit';
                    if (item.asset_type === 'stock') { displayQty = displayQty / 100; unitType = 'Lot'; }

                    return `
                    <tr id="row-${item.id}" class="hover:bg-blue-50 transition group border-b border-gray-50">
                        <td class="p-4 flex items-center gap-3">
                            <img src="${item.logo_url}" class="w-10 h-10 rounded-full object-cover border bg-white shadow-sm" onerror="this.onerror=null; this.src='https://via.placeholder.com/40';">
                            <div>
                                <p class="font-bold text-gray-700">${item.name}</p>
                                <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide">${item.asset_type}</span>
                            </div>
                        </td>

                        <td class="p-4 text-center text-gray-400 text-xs">
                            <i class="fa-solid fa-chart-line"></i>
                        </td>

                        <td class="p-4 text-right font-mono text-gray-500 text-sm">
                            Rp ${new Intl.NumberFormat('id-ID').format(item.purchase_price)}
                        </td>

                        <td id="live-price-${item.id}" class="p-4 text-right bg-gray-50 font-mono font-bold text-gray-800" data-value="${item.purchase_price}">
                            <i class="fa-solid fa-spinner fa-spin text-blue-500 text-xs"></i>
                        </td>

                        <td id="change-${item.id}" class="p-4 text-center">
                            -
                        </td>

                        <td class="p-4 text-center font-mono font-bold text-gray-700">
                            ${new Intl.NumberFormat('id-ID').format(displayQty)} <span class="text-xs text-gray-400 font-normal">${unitType}</span>
                        </td>

                        <td id="total-value-${item.id}" class="p-4 text-right font-mono font-bold text-gray-800 text-lg">
                            Rp ${new Intl.NumberFormat('id-ID').format(total)}
                        </td>

                        <td class="p-4 text-center whitespace-nowrap">
                            <button onclick="openSellModal(${item.id}, '${item.name}', ${item.quantity}, '${item.asset_type}')" class="text-green-500 hover:text-green-700 hover:bg-green-50 p-2 rounded transition mr-1"><i class="fa-solid fa-money-bill-wave"></i></button>
                            <button onclick="editAsset(${item.id})" class="text-yellow-500 hover:text-yellow-700 hover:bg-yellow-50 p-2 rounded transition mr-1"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button onclick="deleteAsset(${item.id})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>`;
                }).join('');

                // Mulai polling live data setelah tabel jadi
                startLivePolling();

            } catch (err) {
                if(err.response && err.response.status === 401) logout();
            }
        }

        // --- 2. USER PROFILE & FORM LOGIC (SAMA SEPERTI SEBELUMNYA) ---
        async function fetchUserProfile() {
            try {
                const res = await axios.get('/api/user', { headers: { Authorization: `Bearer ${token}` } });
                document.getElementById('navUserName').innerText = res.data.name;
                document.getElementById('navUserEmail').innerText = res.data.email;
            } catch (error) { if(error.response && error.response.status === 401) logout(); }
        }
        function toggleProfileMenu() { document.getElementById('profileMenu').classList.toggle('hidden'); }
        function closeDropdown(event) {
            const menu = document.getElementById('profileMenu');
            const button = document.querySelector('button[onclick="toggleProfileMenu()"]');
            if (!button.contains(event.target) && !menu.contains(event.target)) menu.classList.add('hidden');
        }

        function updateFormLabels() {
            const type = document.getElementById('asset_type').value;
            const labelQty = document.getElementById('labelInputQty');
            const helperQty = document.getElementById('helperInputQty');
            if (type === 'stock') {
                labelQty.innerText = "Jumlah (Lot)";
                helperQty.innerText = "*Input dalam Lot (Sistem otomatis kalikan 100)";
                document.getElementById('quantity').placeholder = "Contoh: 10";
            } else {
                labelQty.innerText = "Jumlah (Unit)";
                helperQty.innerText = "";
                document.getElementById('quantity').placeholder = "Contoh: 0.5";
            }
        }

        function openModal(mode, data = null) {
            document.getElementById('assetModal').classList.remove('hidden');
            const form = document.getElementById('assetForm');
            const title = document.getElementById('modalTitle');
            if (mode === 'create') {
                title.innerText = "Tambah Aset Baru";
                document.getElementById('assetId').value = '';
                form.reset(); document.getElementById('asset_type').value = 'stock'; updateFormLabels();
            } else {
                title.innerText = "Edit Aset";
                document.getElementById('assetId').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('asset_type').value = data.asset_type;
                document.getElementById('purchase_date').value = data.purchase_date;
                document.getElementById('purchase_price').value = data.purchase_price;
                let showQty = data.quantity;
                if (data.asset_type === 'stock') showQty = showQty / 100;
                document.getElementById('quantity').value = showQty;
                updateFormLabels();
            }
        }
        function closeModal() { document.getElementById('assetModal').classList.add('hidden'); }

        async function saveAsset() {
            const id = document.getElementById('assetId').value;
            const assetType = document.getElementById('asset_type').value;
            let qtyInput = parseFloat(document.getElementById('quantity').value);
            if (assetType === 'stock') qtyInput = qtyInput * 100;

            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('asset_type', assetType);
            formData.append('purchase_price', document.getElementById('purchase_price').value);
            formData.append('quantity', qtyInput);
            formData.append('purchase_date', document.getElementById('purchase_date').value);
            const logoFile = document.getElementById('logo').files[0];
            if (logoFile) formData.append('logo', logoFile);

            try {
                let url = '/api/assets'; if (id) { url += `/${id}`; formData.append('_method', 'POST'); }
                await axios.post(url, formData, { headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'multipart/form-data' } });
                closeModal(); loadData();
                Swal.fire('Berhasil!', 'Data tersimpan.', 'success');
            } catch (error) { Swal.fire('Error!', 'Gagal menyimpan.', 'error'); }
        }

        async function editAsset(id) { try { const res = await axios.get(`/api/assets/${id}`, { headers: { Authorization: `Bearer ${token}` } }); openModal('edit', res.data); } catch (e) { Swal.fire('Error', 'Gagal ambil data', 'error'); } }
        async function deleteAsset(id) {
            const result = await Swal.fire({ title: 'Hapus?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya' });
            if (result.isConfirmed) { try { await axios.delete(`/api/assets/${id}`, { headers: { Authorization: `Bearer ${token}` } }); loadData(); Swal.fire('Terhapus!', '', 'success'); } catch (e) { Swal.fire('Gagal!', '', 'error'); } }
        }

        function openSellModal(id, name, stock, type) {
            document.getElementById('sellModal').classList.remove('hidden');
            document.getElementById('sellAssetId').value = id;
            document.getElementById('sellAssetName').innerText = name;
            currentAssetType = type;
            const labelQty = document.getElementById('labelQty');
            const labelPrice = document.getElementById('labelPrice');
            const stockDisplay = document.getElementById('sellCurrentStock');
            const infoText = document.getElementById('lotConversionInfo');

            if (currentAssetType === 'stock') {
                const stockInLot = stock / 100;
                stockDisplay.innerText = stockInLot + ' Lot';
                labelQty.innerText = "Jumlah LOT yang dijual:";
                labelPrice.innerText = "Harga Pasar per LEMBAR (Rp):";
                document.getElementById('sellAmount').placeholder = "Contoh: 10"; document.getElementById('sellPrice').placeholder = "Contoh: 50";
                infoText.classList.remove('hidden'); infoText.innerText = "Otomatis: 0 Lot = 0 Lembar";
            } else {
                stockDisplay.innerText = stock + ' Unit'; labelQty.innerText = "Jumlah Unit yang dijual:"; labelPrice.innerText = "Harga per Unit (Rp):"; infoText.classList.add('hidden');
            }
            document.getElementById('sellAmount').value = ''; document.getElementById('sellPrice').value = ''; document.getElementById('totalEstimation').innerText = 'Rp 0';
        }
        function closeSellModal() { document.getElementById('sellModal').classList.add('hidden'); }

        ['sellAmount', 'sellPrice'].forEach(elemId => {
            const elem = document.getElementById(elemId);
            if(elem) elem.addEventListener('input', function() {
                const qtyInput = parseFloat(document.getElementById('sellAmount').value) || 0;
                const priceInput = parseFloat(document.getElementById('sellPrice').value) || 0;
                let total = 0;
                if (currentAssetType === 'stock') {
                    const totalLembar = qtyInput * 100; total = totalLembar * priceInput;
                    document.getElementById('lotConversionInfo').innerText = `Otomatis: ${qtyInput} Lot = ${totalLembar.toLocaleString()} Lembar`;
                } else total = qtyInput * priceInput;
                document.getElementById('totalEstimation').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
            });
        });

        async function confirmSell() {
            const id = document.getElementById('sellAssetId').value;
            let qtyInput = parseFloat(document.getElementById('sellAmount').value);
            let priceInput = parseFloat(document.getElementById('sellPrice').value);
            if(!qtyInput || qtyInput <= 0 || !priceInput) { Swal.fire('Peringatan', 'Isi data dengan benar', 'warning'); return; }
            let finalAmount = qtyInput; if (currentAssetType === 'stock') finalAmount = qtyInput * 100;
            try {
                const response = await axios.post('/api/transactions', { asset_id: id, type: 'sell', amount: finalAmount, price: priceInput }, { headers: { 'Authorization': `Bearer ${token}` } });
                closeSellModal(); loadData();
                Swal.fire('Berhasil!', `Total: ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.data.total_uang)}`, 'success');
            } catch (error) { Swal.fire('Gagal!', error.response?.data?.message || 'Error', 'error'); }
        }

        async function logout() { try { await axios.post('/api/logout', {}, { headers: { Authorization: `Bearer ${token}` } }); } catch(e){} localStorage.removeItem('token'); window.location.href = '/'; }

        loadData(); fetchUserProfile();
    </script>
</body>
</html>
