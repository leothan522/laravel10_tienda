<?php

namespace App\Exports;

use App\Models\Ajuste;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class AjustesExport implements FromView, ShouldAutoSize, WithTitle
{
    private $reporte, $empresa, $hoy, $desde, $hasta, $ajustes, $anulado, $tipo, $articulo, $almacen;
    public function __construct($reporte, $empresa, $hoy, $desde, $hasta, $ajustes, $anulado, $tipo, $articulo, $almacen)
    {
        $this->reporte = $reporte;
        $this->empresa = $empresa;
        $this->hoy = $hoy;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->ajustes = $ajustes;
        $this->anulado = $anulado;
        $this->tipo = $tipo;
        $this->articulo = $articulo;
        $this->almacen = $almacen;
    }

    public function view(): View
    {
        return view('dashboard.stock.excel_ajustes')
            ->with('reporte', $this->reporte)
            ->with('empresa', $this->empresa)
            ->with('hoy', $this->hoy)
            ->with('desde', $this->desde)
            ->with('hasta', $this->hasta)
            ->with('listarAjustes', $this->ajustes)
            ->with('anulado', $this->anulado)
            ->with('tipo', $this->tipo)
            ->with('articulo', $this->articulo)
            ->with('almacen', $this->almacen)
            ;
    }

    public function title(): string
    {
        if ($this->reporte == "numero"){
            $texto = "AJUSTES POR NUMERO";
        }else{
            $texto = "AJUSTES POR ARTICULOS";
        }
        return $texto;
    }
}
