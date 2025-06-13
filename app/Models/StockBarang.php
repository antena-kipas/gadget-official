<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockBarang extends Model
{
    use HasFactory;

    protected $table = 'stock_barangs';

    protected $fillable = [
        'uniq_key',
        'harga_satuan',
        'harga_total',
        'kuantitas',
        'nama_toko_suplier',
        'jenis_pembayaran',
        'status_pembayaran',
        'hutang',
    ];
}
