<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- WAJIB: Untuk tahu siapa yang login
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    // GET ALL (Hanya Aset Milik Saya)
    // GET ALL (Hanya Aset Milik Saya & STOK > 0)
    public function index()
    {
        $userId = Auth::id();

        // Update: Tambahkan where('quantity', '>', 0)
        // Agar aset yang sudah terjual habis tidak muncul lagi
        $assets = Asset::where('user_id', $userId)
                       ->where('quantity', '>', 0)
                       ->get();

        return response()->json($assets);
    }

    // CREATE (Simpan dengan Tanda Tangan User)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'asset_type' => 'required|string',
            'purchase_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'purchase_date' => 'required|date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Upload Logo (Jika ada)
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo_url'] = '/storage/' . $path;
        }

        // 2. Masukkan ID User secara otomatis
        $validated['user_id'] = Auth::id();

        // 3. Simpan
        $asset = Asset::create($validated);

        return response()->json($asset, 201);
    }

    // SHOW DETAIL (Hanya Jika Milik Sendiri)
    public function show($id)
    {
        // Cari Aset yang ID-nya X DAN User-nya SAYA
        $asset = Asset::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$asset) {
            return response()->json(['message' => 'Asset not found or unauthorized'], 404);
        }
        return response()->json($asset);
    }

    // UPDATE (Hanya Jika Milik Sendiri)
    public function update(Request $request, $id)
    {
        // Cari Aset Milik User
        $asset = Asset::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$asset) {
            return response()->json(['message' => 'Asset not found or unauthorized'], 404);
        }

        // Update Data
        if ($request->has('name')) $asset->name = $request->name;
        if ($request->has('asset_type')) $asset->asset_type = $request->asset_type;
        if ($request->has('purchase_price')) $asset->purchase_price = $request->purchase_price;
        if ($request->has('quantity')) $asset->quantity = $request->quantity;
        if ($request->has('purchase_date')) $asset->purchase_date = $request->purchase_date;

        if ($request->hasFile('logo')) {
            if ($asset->logo_url && file_exists(public_path($asset->logo_url))) {
                @unlink(public_path($asset->logo_url));
            }
            $path = $request->file('logo')->store('logos', 'public');
            $asset->logo_url = '/storage/' . $path;
        }

        $asset->save();

        return response()->json([
            'message' => 'Asset updated successfully',
            'data' => $asset
        ], 200);
    }

    // DELETE (Hanya Jika Milik Sendiri)
    public function destroy($id)
    {
        // Cari Aset Milik User
        $asset = Asset::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$asset) {
            return response()->json(['message' => 'Asset not found or unauthorized'], 404);
        }

        if ($asset->logo_url && file_exists(public_path($asset->logo_url))) {
            @unlink(public_path($asset->logo_url));
        }

        $asset->delete();
        return response()->json(['message' => 'Asset deleted']);
    }


    // SIMULASI HARGA PASAR (LIVE)
    public function getLivePrices()
    {
        $userId = Auth::id();
        $assets = Asset::where('user_id', $userId)->where('quantity', '>', 0)->get();

        $liveData = $assets->map(function ($asset) {
            // LOGIKA SIMULASI: Harga bergerak acak +/- 2% dari harga beli
            // Biar terlihat real, kita pakai random seed waktu
            $volatility = rand(-20, 25) / 1000; // -2.0% s/d +2.5%

            // Harga dasar (seolah-olah harga pasar saat ini)
            $marketPrice = $asset->purchase_price * (1 + $volatility);

            // Bulatkan harga saham (biasanya kelipatan 5 atau 1)
            $marketPrice = round($marketPrice);

            // Hitung Gain/Loss
            $diff = $marketPrice - $asset->purchase_price;
            $percentage = ($diff / $asset->purchase_price) * 100;

            // Hitung Total Value Realtime (Ingat aturan Saham dikali 100 lembar)
            $realQty = $asset->quantity; // Ini masih data database (Lembar untuk saham)
            // Di database kita simpan "Lembar", jadi hitungan matematikanya langsung:
            // Total = Lembar x Harga Pasar
            $totalValue = $realQty * $marketPrice;

            return [
                'id' => $asset->id,
                'market_price' => $marketPrice,
                'change_rp' => $diff,
                'change_pct' => round($percentage, 2),
                'total_value' => $totalValue,
                'is_profit' => $diff >= 0
            ];
        });

        return response()->json($liveData);
    }
}
