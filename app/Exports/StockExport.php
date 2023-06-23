<?php

namespace App\Exports;

use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromView, ShouldAutoSize, WithColumnFormatting, WithStyles, WithTitle
{
    private $stock, $nivel, $tipo, $empresa, $codigoUnidad, $codigoAlmacen, $fecha;

    public function __construct($stock, $nivel, $tipo, $empresa, $codigoUnidad, $codigoAlmacen, $fecha)
    {
        $this->stock = $stock;
        $this->nivel = $nivel;
        $this->tipo = $tipo;
        $this->empresa = $empresa;
        $this->codigoUnidad = $codigoUnidad;
        $this->codigoAlmacen = $codigoAlmacen;
        $this->fecha = $fecha;
    }

    public function view(): View
    {
        return view('dashboard.stock.excel_stock')
            ->with('listarStock', $this->stock)
            ->with('nivel', $this->nivel)
            ->with('tipo', $this->tipo)
            ->with('empresa', $this->empresa)
            ->with('unidad', $this->codigoUnidad)
            ->with('almacen', $this->codigoAlmacen)
            ->with('fecha', $this->fecha)
            ;
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    }

    public function title(): string
    {
        return "ARTÍCULOS CON SU STOCK";
    }
}
