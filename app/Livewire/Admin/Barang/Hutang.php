<?php
namespace App\Livewire\Admin\Barang;

use Livewire\Component;
use App\Models\StockBarang;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.layouts.admin')]
#[Title('Daftar Hutang')]
class Hutang extends Component
{
    use WithPagination;

    public function render()
    {
        if (request()->get('export') === 'pdf') {
            return $this->exportPdf(); // panggil fungsi export langsung
        }

        $hutangBarangs = StockBarang::where('jenis_pembayaran', 'kredit')
            ->where('hutang', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.barang.hutang', [
            'hutangBarangs' => $hutangBarangs,
        ]);
    }


    public function exportPdf()
    {
        $hutangBarangs = StockBarang::where('jenis_pembayaran', 'kredit')
            ->where('hutang', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.hutang-barang', compact('hutangBarangs'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-hutang-barang.pdf');
    }
}
