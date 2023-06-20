<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AjusDetalle;
use App\Models\Ajuste;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return view('dashboard.stock.index');
    }

    public function printAjustes($id)
    {
        $ajuste = Ajuste::find($id);
        if (!$ajuste){
            return redirect()->route('stock.index');
        }
        $listarDetalles = AjusDetalle::where('ajustes_id', $ajuste->id)->get();
        return view('dashboard.stock.print_ajuste')
            ->with('ajuste_id', $id)
            ->with('empresa', $ajuste->empresas->nombre)
            ->with('ajuste_codigo', $ajuste->codigo)
            ->with('ajuste_fecha', $ajuste->fecha)
            ->with('ajuste_descripcion', $ajuste->descripcion)
            ->with('listarDetalles', $listarDetalles);
    }
}
