<?php

namespace App\Exports;

use App\Models\Articulo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArticulosExport implements FromView, ShouldAutoSize, WithTitle, WithStyles, WithColumnFormatting
{
    public $empresa, $hoy, $reporte, $articulos, $categoria, $unidad, $procedencia, $tributario, $tipo, $estatus;

    public function __construct($empresa, $hoy, $reporte, $articulos, $categoria, $unidad, $procedencia, $tributario, $tipo, $estatus)
    {
        $this->empresa = $empresa;
        $this->hoy = $hoy;
        $this->reporte = $reporte;
        $this->articulos = $articulos;
        $this->categoria = $categoria;
        $this->unidad = $unidad;
        $this->procedencia = $procedencia;
        $this->tributario = $tributario;
        $this->tipo = $tipo;
        $this->estatus = $estatus;
    }

    public function view(): View
    {
        return view('dashboard.articulos.excel_articulos')
            ->with('empresa', $this->empresa)
            ->with('hoy', $this->hoy)
            ->with('reporte', $this->reporte)
            ->with('listarArticulos', $this->articulos)
            ->with('categoria', $this->categoria)
            ->with('unidad', $this->unidad)
            ->with('procedencia', $this->procedencia)
            ->with('tributario', $this->tributario)
            ->with('tipo', $this->tipo)
            ->with('estatus', $this->estatus)
            ;
    }

    public function title(): string
    {
        if ($this->reporte == "unidades"){
            $texto = "ARTÍCULOS UNIDADES";
        }else{
            $texto = "ARTÍCULOS PRECIOS";
        }
        return $texto;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
