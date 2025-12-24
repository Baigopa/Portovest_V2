<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    // GET ALL
    public function index()
    {
        $assets = Asset::all();
        return response()->json($assets);
    }

    // CREATE
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

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo_url'] = '/storage/' . $path;
        }

        $asset = Asset::create($validated);

        return response()->json($asset, 201);
    }

    // SHOW DETAIL (UBAH: Pakai ID)
    public function show($id)
    {
        // Cari pakai ID (Primary Key)
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['message' => 'Asset not found'], 404);
        }
        return response()->json($asset);
    }

    // UPDATE (UBAH: Pakai ID)
    public function update(Request $request, $id)
    {
        // Cari pakai ID
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['message' => 'Asset not found'], 404);
        }

        // --- UPDATE MANUAL DATA TEXT ---
        if ($request->has('name')) $asset->name = $request->name;
        if ($request->has('asset_type')) $asset->asset_type = $request->asset_type;
        if ($request->has('purchase_price')) $asset->purchase_price = $request->purchase_price;
        if ($request->has('quantity')) $asset->quantity = $request->quantity;
        if ($request->has('purchase_date')) $asset->purchase_date = $request->purchase_date;

        // --- UPDATE GAMBAR (LOGO) ---
        if ($request->hasFile('logo')) {
            // Hapus gambar lama jika ada (Opsional, biar hemat storage)
            if ($asset->logo_url && file_exists(public_path($asset->logo_url))) {
                @unlink(public_path($asset->logo_url));
            }

            // Upload baru
            $path = $request->file('logo')->store('logos', 'public');
            $asset->logo_url = '/storage/' . $path;
        }

        $asset->save();

        return response()->json([
            'message' => 'Asset updated successfully',
            'data' => $asset
        ], 200);
    }

    // DELETE (UBAH: Pakai ID)
    public function destroy($id)
    {
        // Cari pakai ID
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['message' => 'Asset not found'], 404);
        }

        // Hapus file gambar jika ada
        if ($asset->logo_url && file_exists(public_path($asset->logo_url))) {
            @unlink(public_path($asset->logo_url));
        }

        $asset->delete();
        return response()->json(['message' => 'Asset deleted']);
    }
}
