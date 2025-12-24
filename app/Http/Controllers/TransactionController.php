<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        // Kita wajibkan user mengirim 'price' (harga jual/beli yang diinginkan)
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'type' => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.0001', // Bisa desimal
            'price' => 'required|numeric|min:0',       // <--- HARUS ADA HARGA
        ]);

        // 2. LOGIKA TRANSAKSI (DATABASE TRANSACTION)
        // Pakai DB::transaction biar kalau error di tengah, data tidak rusak
        return DB::transaction(function () use ($request) {

            // Ambil data aset yang mau dtransaksikan
            $asset = Asset::find($request->asset_id);

            // LOGIKA PENGURANGAN / PENAMBAHAN STOK
            if ($request->type == 'sell') {
                // Cek apakah stok cukup?
                if ($asset->quantity < $request->amount) {
                    return response()->json(['error' => 'Stok aset tidak cukup!'], 400);
                }
                $asset->quantity -= $request->amount; // Kurangi stok
            } else {
                $asset->quantity += $request->amount; // Tambah stok (jika nanti ada fitur beli)
            }

            // Simpan perubahan stok aset
            $asset->save();

            // 3. SIMPAN RIWAYAT TRANSAKSI
            $transaction = Transaction::create([
                'user_id' => Auth::id(), // Ambil ID user yang sedang login
                'asset_id' => $request->asset_id,
                'type' => $request->type,
                'amount' => $request->amount,

                // PENTING: Gunakan harga dari INPUT USER, bukan harga database
                'price_per_unit' => $request->price,
            ]);

            // Hitung total uang untuk respon
            $totalUang = $request->amount * $request->price;

            // 4. KIRIM RESPON JSON SUKSES
            return response()->json([
                'message' => 'Transaksi berhasil',
                'sisa_stok_aset' => $asset->quantity,
                'total_uang' => $totalUang, // Kirim info total uang ke frontend
                'transaksi' => $transaction
            ], 201);
        });
    }
}
