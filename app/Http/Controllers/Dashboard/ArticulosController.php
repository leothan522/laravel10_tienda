<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ArticulosExport;
use App\Http\Controllers\Controller;
use App\Models\Articulo;
use App\Models\ArtUnid;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Precio;
use App\Models\Procedencia;
use App\Models\TipoArticulo;
use App\Models\Tributario;
use App\Models\Unidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ArticulosController extends Controller
{
    public function index()
    {
        return view('dashboard.articulos.index');
    }

    public function reporteArticulos(Request $request)
    {
        $empresa_id = $request->empresa_id;
        $reporte = $request->reporte;
        $categoria = $request->categoria;
        $unidad = $request->unidad;
        $procedencia = $request->procedencia;
        $tributario = $request->tributario;
        $tipo = $request->tipo;
        $estatus = $request->estatus;

        $hoy = Carbon::now()->format('d-m-Y h:i:s a');
        $label = str_replace(':', '-', $hoy);

        $empresa = Empresa::find($empresa_id);

        $articulos = Articulo::orderBy('codigo', 'asc')->get();
        foreach ($articulos as $articulo){
            $unidades = ArtUnid::where('articulos_id', $articulo->id)->get();
            $articulo->get_unidades = $unidades;
            if ($reporte == "precios"){
                $precio = Precio::where('empresas_id', $empresa_id)->where('articulos_id', $articulo->id)->where('unidades_id', $articulo->unidades_id)->first();
                if ($precio){
                    $array = calcularPrecios($empresa_id, $articulo->id, $articulo->tributarios_id, $articulo->unidades_id);
                    $articulo->precios = $array;
                }else{
                    $articulo->precio = null;
                }
                foreach ($articulo->get_unidades as $get){
                    $precio = Precio::where('empresas_id', $empresa_id)->where('articulos_id', $articulo->id)->where('unidades_id', $get->unidades_id)->first();
                    if ($precio){
                        $array = calcularPrecios($empresa_id, $articulo->id, $articulo->tributarios_id, $get->unidades_id);
                        $get->precios = $array;
                    }else{
                        $get->precios = null;
                    }
                }
            }
        }

        if ($categoria != "all"){
            $categoria = Categoria::find($categoria);
        }

        if ($unidad != "all"){
            $unidad = Unidad::find($unidad);
        }

        if ($procedencia != "all"){
            $procedencia = Procedencia::find($procedencia);
        }

        if ($tributario != "all"){
            $tributario = Tributario::find($tributario);
        }

        if ($tipo != "all"){
            $tipo = TipoArticulo::find($tipo);
        }

        /*return view('dashboard.articulos.excel_articulos')
            ->with('empresa', $empresa)
            ->with('hoy', $hoy)
            ->with('reporte', $reporte)
            ->with('listarArticulos', $articulos)
            ->with('categoria', $categoria)
            ->with('unidad', $unidad)
            ->with('procedencia', $procedencia)
            ->with('tributario', $tributario)
            ->with('tipo', $tipo)
            ->with('estatus', $estatus)
            ;*/
        return Excel::download(new ArticulosExport($empresa, $hoy, $reporte, $articulos, $categoria, $unidad, $procedencia, $tributario, $tipo, $estatus), 'Articulos '.$label.'.xlsx');
    }
}
