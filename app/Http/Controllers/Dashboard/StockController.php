<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\AjustesExport;
use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Models\AjusDetalle;
use App\Models\Ajuste;
use App\Models\AjusTipo;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Stock;
use App\Models\Unidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function reporteStock(Request $request)
    {

        $nivel = $request->nivel;
        $tipo = $request->tipo;
        $unidad = $request->unidad;
        $almacen = $request->almacen;
        $empresa_id = $request->empresa_id;
        $fecha = Carbon::now()->format('d-m-Y h:i:s a');
        $label = str_replace(':', '-', $fecha);

        $empresa = Empresa::find($empresa_id);
        $codigoUnidad = null;
        if ($unidad != "all"){
            $getUnidad = Unidad::find($unidad);
            $codigoUnidad = $getUnidad->codigo;
        }
        $codigoAlmacen = null;
        if ($almacen != "all"){
            $getAlmacen = Almacen::find($almacen);
            $codigoAlmacen = $getAlmacen->codigo;
        }


        if ($unidad == "all" && $almacen == "all"){
            $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id', 'estatus'])
                ->groupBy('empresas_id', 'articulos_id', 'unidades_id', 'estatus')
                ->having('empresas_id', $empresa_id)
                ->orderBy('articulos_id', 'asc')
                ->get();
        }else{
            if ($unidad != "all" && $almacen == "all"){
                $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id', 'estatus'])
                    ->groupBy('empresas_id', 'articulos_id', 'unidades_id', 'estatus')
                    ->having('empresas_id', $empresa_id)
                    ->having('unidades_id', $unidad)
                    ->orderBy('articulos_id', 'asc')
                    ->get();
            }
            if ($almacen != "all" && $unidad == "all"){
                $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id', 'almacenes_id', 'estatus'])
                    ->groupBy('empresas_id', 'articulos_id', 'unidades_id', 'almacenes_id', 'estatus')
                    ->having('empresas_id', $empresa_id)
                    ->having('almacenes_id', $almacen)
                    ->orderBy('articulos_id', 'asc')
                    ->get();
            }

            if ($unidad != "all" && $almacen != "all"){
                $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id', 'almacenes_id', 'estatus'])
                    ->groupBy('empresas_id', 'articulos_id', 'unidades_id', 'almacenes_id', 'estatus')
                    ->having('empresas_id', $empresa_id)
                    ->having('almacenes_id', $almacen)
                    ->having('unidades_id', $unidad)
                    ->orderBy('articulos_id', 'asc')
                    ->get();
            }

        }

        $stock->each(function ($stock) {

            $articulo = Articulo::find($stock->articulos_id);
            $unidad = Unidad::find($stock->unidades_id);

            $stock->activo = $articulo->estatus;
            $stock->codigo = $articulo->codigo;
            $stock->articulo = $articulo->descripcion;
            $stock->unidad = $unidad->codigo;

            $resultado = calcularPrecios($stock->empresas_id, $stock->articulos_id, $articulo->tributarios_id, $stock->unidades_id);
            $stock->moneda = $resultado['moneda_base'];
            $stock->dolares = $resultado['precio_dolares'];
            $stock->bolivares = $resultado['precio_bolivares'];
            $stock->iva_dolares = $resultado['iva_dolares'];
            $stock->iva_bolivares = $resultado['iva_bolivares'];
            $stock->neto_dolares = $resultado['neto_dolares'];
            $stock->neto_bolivares = $resultado['neto_bolivares'];

            if ($stock->almacenes_id){
                $existencias = Stock::where('empresas_id', $stock->empresas_id)
                    ->where('articulos_id', $articulo->id)
                    ->where('unidades_id', $unidad->id)
                    ->where('almacenes_id', $stock->almacenes_id)
                    ->get();
            }else{
                $existencias = Stock::where('empresas_id', $stock->empresas_id)
                    ->where('articulos_id', $articulo->id)
                    ->where('unidades_id', $unidad->id)
                    ->get();
            }


            $array = array();
            $actual = 0;
            $comprometido = 0;
            $disponible = 0;
            $vendido = 0;
            foreach ($existencias as $existencia) {
                $array[] = [
                    'id' => $existencia->id,
                    'almacen' => $existencia->almacen->codigo,
                    'actual' => $existencia->actual,
                    'comprometido' => $existencia->comprometido,
                    'disponible' => $existencia->disponible
                ];
                $actual = $actual + $existencia->actual;
                $comprometido = $comprometido + $existencia->comprometido;
                $disponible = $disponible + $existencia->disponible;
                $vendido = $vendido + $existencia->vendido;
            }

            $stock->actual = $actual;
            $stock->comprometido = $comprometido;
            $stock->disponible = $disponible;
            $stock->existencias = $array;
            $stock->vendido = $vendido;

        });

        /*return view('dashboard.stock.excel_stock')
            ->with('listarStock', $stock)
            ->with('nivel', $nivel)
            ->with('tipo', $tipo)
            ->with('empresa', $empresa)
            ->with('unidad', $codigoUnidad)
            ->with('almacen', $codigoAlmacen)
            ->with('fecha', $fecha)
            ;*/
        return Excel::download(new StockExport($stock, $nivel, $tipo, $empresa, $codigoUnidad, $codigoAlmacen, $fecha), 'Stock '.$label.'.xlsx');
    }

    public function reporteAjustes(Request $request)
    {
        $reporte = $request->reporte;
        $desde = $request->desde;
        $hasta = $request->hasta;
        $tipo = $request->tipo;
        $articulo = $request->articulo;
        $almacen = $request->almacen;
        $anulado = $request->anulado;

        $hoy = Carbon::now()->format('d-m-Y h:i:s a');
        $label = str_replace(':', '-', $hoy);

        $empresa_id = $request->empresa_id;
        $empresa = Empresa::find($empresa_id);

        if ($reporte == "numero"){
            $ajustes = Ajuste::where('empresas_id', $empresa_id)->orderBy('codigo', 'asc')->get();
            $ajustes->each(function ($ajuste){
                $ajuste->detalles = AjusDetalle::where('ajustes_id', $ajuste->id)->get();
            });
        }else{
            //ajustes por articulo
            $ajustes = Articulo::where('estatus', 1)->get();
            foreach ($ajustes as $ajuste){
                $contador = 0;
                $total = 0;
                $detalles = AjusDetalle::where('articulos_id', $ajuste->id)->get();
                foreach ($detalles as $detalle){
                    if ($empresa_id == $detalle->ajustes->empresas_id){
                        $contador++;
                        if ($detalle->tipo->tipo == 1){
                            $total = $total + $detalle->cantidad;
                        }else{
                            $total = $total - $detalle->cantidad;
                        }

                    }
                }
                if ($contador){
                    $ajuste->contador = true;
                }
                $ajuste->detalles = $detalles;
                $ajuste->total = $total;
            }
        }


        if ($tipo != "all"){
            $tipo = AjusTipo::find($tipo);
        }
        if ($articulo != "all"){
            $articulo = Articulo::find($articulo);
        }
        if ($almacen != "all"){
            $almacen = Almacen::find($almacen);
        }

        /*return view('dashboard.stock.excel_ajustes')
            ->with('reporte', $reporte)
            ->with('empresa', $empresa)
            ->with('hoy', $hoy)
            ->with('desde', $desde)
            ->with('hasta', $hasta)
            ->with('listarAjustes', $ajustes)
            ->with('anulado', $anulado)
            ->with('tipo', $tipo)
            ->with('articulo', $articulo)
            ->with('almacen', $almacen)
            ;*/

        return Excel::download(new AjustesExport($reporte, $empresa, $hoy, $desde, $hasta, $ajustes, $anulado, $tipo, $articulo, $almacen), 'Ajustes '.$label.'.xlsx');
    }
}
