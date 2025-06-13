<div>
    <h1 class="text-3xl font-bold pb-5 dark:text-white">Laporan Hutang Barang</h1>

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.hutang.export') }}"
        class="inline-block px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 transition">
            Export PDF
        </a>
    </div>


    @if (session()->has('message'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border dark:border-gray-700">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Barang</th>
                    <th class="px-6 py-3 text-center">Toko</th>
                    <th class="px-6 py-3 text-center">Jenis Pembayaran</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Nominal Hutang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hutangBarangs as $index => $barang)

                    @if ($barang->hutang > 0)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $hutangBarangs->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                        <td class="px-6 py-4 text-center">{{ $barang->nama_toko_suplier }}</td>
                        <td class="px-6 py-4 text-center">{{ ucfirst($barang->jenis_pembayaran) }}</td>
                        <td class="px-6 py-4 text-center">{{ ucfirst($barang->status_pembayaran) }}</td>
                        <td class="px-6 py-4 text-center text-red-600 font-bold">
                            Rp {{ number_format($barang->hutang, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data hutang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($hutangBarangs->hasPages())
    <div class="mt-6">
        {{ $hutangBarangs->links() }}
    </div>
    @endif

</div>
