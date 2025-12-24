<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Jangan lupa import ini untuk UUID

class Asset extends Model
{
    use HasFactory;

    // Pastikan semua kolom ini bisa diisi
    protected $fillable = [
        'user_id',
        'uuid',
        'name',
        'asset_type',
        'quantity',
        'purchase_price',
        'purchase_date',
        'logo_url'
    ];

    // Fungsi Otomatis isi UUID saat Create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Relasi ke Transaksi (Untuk fitur Jual/Beli nanti)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
// <-- Pastikan kurung kurawal penutup class ini ada di paling akhir
