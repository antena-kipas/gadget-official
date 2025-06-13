<div>
    <div>
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tambah Barang</h1>
                {{-- Asumsi Anda memiliki route untuk kembali ke daftar produk --}}
                <a href="{{ route('admin.barang.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    &larr; Kembali ke Daftar Barang
                </a>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    {{ session('message') }}
                </div>
            @endif




            <form wire:submit.prevent="saveProduct" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                {{-- Pilih Toko --}}
                <div>
                    <label for="toko" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Toko</label>
                    <select id="toko" wire:model.live="selectedToko""
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Pilih Toko --</option>
                        @foreach ($tokoOptions as $id => $nama)
                            <option value="{{ (string) $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                    @error('selectedToko') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                
                {{-- Pilih Barang --}}
                <div>
                    <label for="barang_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                    <select id="barang_id" wire:model.live="selectedBarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barangOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                    @error('selectedBarang') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Jenis Pembayaran --}}
                    <div>
                        <label for="jenis_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Pembayaran</label>
                        <select id="jenis_pembayaran" wire:model.live="jenisPembayaran"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Jenis Pembayaran --</option>
                            <option value="tunai">Tunai</option>
                            <option value="kredit">Kredit</option>
                        </select>
                        @error('jenisPembayaran') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nominal Pembayaran (hanya jika Kredit) --}}
                    @if ($jenisPembayaran === 'kredit')
                    <div class="mt-4">
                        <label for="nominalPembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nominal Pembayaran
                        </label>
                        <input type="number" id="nominalPembayaran" wire:model="nominalPembayaran"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="Masukkan jumlah pembayaran">
                        @error('nominalPembayaran')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                <div>
                    <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                    <input type="number" id="stock" wire:model.lazy="stock"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Contoh: 100">
                    @error('stock')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Tombol Aksi --}}
                <div class="flex justify-end pt-4">
                    <button type="submit" wire:loading.attr="disabled" wire:target="saveProduct"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-75 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        <span wire:loading.remove wire:target="saveProduct">Tambah Barang</span>
                        <span wire:loading wire:target="saveProduct">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
