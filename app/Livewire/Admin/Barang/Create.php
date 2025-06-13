<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Barang;
use App\Models\StockBarang;
use App\Models\TokoSuplier;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
#[Title('Tambah Barang')]
class Create extends Component
{
    public $selectedToko = '';

    public $selectedBarang;
    public $stock;
    public $tokoOptions = [];
    public $barangOptions = [];
    public $jenisPembayaran = '';
    public $nominalPembayaran;

    protected function rules(): array
    {
        return [
            'selectedToko' => ['required'],
            'selectedBarang' => ['required'],
            'stock' => ['required', 'integer', 'min:0'],
            'jenisPembayaran' => ['required', 'in:tunai,kredit'],
            'nominalPembayaran' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($this->jenisPembayaran === 'kredit' && empty($value)) {
                        $fail('Nominal pembayaran wajib diisi jika memilih kredit.');
                    }
                },
            ],
        ];
    }

    protected $messages = [
        'selectedToko.required' => 'Nama toko wajib dipilih.',
        'selectedBarang.required' => 'Nama barang wajib dipilih.',
        'stock.required' => 'Stok wajib diisi.',
        'stock.integer' => 'Stok harus berupa angka bulat.',
        'jenisPembayaran.required' => 'Jenis pembayaran wajib dipilih.',
        'jenisPembayaran.in' => 'Jenis pembayaran tidak valid.',
    ];

    public function mount()
    {
        $this->stock = 0;
        $this->nominalPembayaran = null;
        $this->jenisPembayaran = '';
        $this->selectedToko = '';
        $this->selectedBarang = '';
        $this->tokoOptions = TokoSuplier::pluck('nama_toko', 'id')->toArray();
    }


    public function updatedSelectedToko($value)
    {
        logger("selectedToko: " . $value); // log ini penting
        $toko = TokoSuplier::find($value);

        if ($toko) {
            logger("Ditemukan: " . $toko->nama_toko);
            $this->barangOptions = Barang::whereRaw('LOWER(TRIM(nama_toko_suplier)) = ?', [
                    strtolower(trim($toko->nama_toko))
                ])
                ->pluck('nama_barang', 'id')
                ->toArray();
        } else {
            logger("Toko ID $value tidak ditemukan.");
            $this->barangOptions = [];
        }

        $this->selectedBarang = null;
    }

    public function saveProduct()
    {
        $validated = $this->validate();

        // Ambil data barang berdasarkan ID yang dipilih
        $barang = Barang::find($this->selectedBarang);

        if (!$barang) {
            session()->flash('message', 'Barang tidak ditemukan.');
            return;
        }

        // Ambil harga beli dari tabel barangs
        $hargaPerSatu = $barang->harga_beli;
        $hargaTotal = $hargaPerSatu * $this->stock;

        // Hitung pembayaran
        if ($this->jenisPembayaran === 'tunai') {
            $pembayaran = $hargaTotal;
        } else {
            $pembayaran = $this->nominalPembayaran ?? 0;
        }

        // Hitung hutang dan status pembayaran
        $hutang = max($hargaTotal - $pembayaran, 0);
        $statusPembayaran = $hutang > 0 ? 'belum_lunas' : 'lunas';

        // Simpan ke tabel stock_barang
        StockBarang::create([
            'nama_barang'        => $barang->nama_barang,
            'uniq_key'           => $barang->unique_key,
            'harga_per_satu'     => $hargaPerSatu,
            'harga_total'        => $hargaTotal,
            'kuantitas'          => $this->stock,
            'nama_toko_suplier'  => $barang->nama_toko_suplier,
            'pembayaran'         => $pembayaran,
            'jenis_pembayaran'   => $this->jenisPembayaran,
            'status_pembayaran'  => $statusPembayaran,
            'hutang'             => $hutang,
        ]);

        session()->flash('message', 'Barang berhasil ditambahkan ke stok.');

        // Reset form
        $this->reset(['selectedToko', 'selectedBarang', 'stock', 'jenisPembayaran', 'nominalPembayaran']);
        $this->stock = 0;

        return redirect()->route('admin.barang.index');
    }


    public function render()
    {
        return view('livewire.admin.barang.create');
    }
}
