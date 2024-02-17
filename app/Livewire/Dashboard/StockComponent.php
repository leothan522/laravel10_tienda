<?php

namespace App\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\Ajuste;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\Stock;
use App\Models\Unidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class StockComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $rows = 0;
    public $empresas_id;
    public $paginate;
    public $getStock;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id'])
            ->groupBy('empresas_id', 'articulos_id', 'unidades_id')
            ->having('empresas_id', $this->empresas_id)
            ->orderBy('articulos_id', 'asc')
            ->paginate($this->paginate);
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
            $stock->oferta_dolares = $resultado['oferta_dolares'];
            $stock->oferta_bolivares = $resultado['oferta_bolivares'];
            $stock->porcentaje = $resultado['porcentaje'];

            $existencias = Stock::where('empresas_id', $stock->empresas_id)
                ->where('articulos_id', $articulo->id)
                ->where('unidades_id', $unidad->id)
                ->get();
            $array = array();
            $actual = 0;
            $comprometido = 0;
            $disponible = 0;
            $vendido = 0;
            $estatus = array();
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

                if ($existencia->almacen_principal){
                    if ($existencia->estatus){
                        $estatus[] = true;
                    }
                }

            }

            $stock->actual = $actual;
            $stock->comprometido = $comprometido;
            $stock->disponible = $disponible;
            $stock->existencias = $array;
            $stock->vendido = $vendido;

            if (!empty($estatus)){
                $stock->estatus = 1;
            }else{
                $stock->estatus = 0;
            }

        });

        return view('livewire.dashboard.stock-component')
            ->with('listarStock', $stock);
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 10) { $rows = 10; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
        $this->paginate = $rows;
    }

    #[On('getEmpresaStock')]
    public function getEmpresaStock($empresaID)
    {
        $this->empresas_id = $empresaID;
    }

    public function setEstatus($existencias)
    {
        foreach (json_decode($existencias) as $existencia) {
            $stock = Stock::find($existencia->id);
            if ($stock->almacen_principal){
                if ($stock->estatus == 1) {
                    $stock->estatus = 0;
                } else {
                    $stock->estatus = 1;
                }
                $stock->update();
            }
        }
    }

    public function showModal(
        $articulos_id,
        $unidades_id,
        $vendido,
        $estatus,
        $existencias,
        $dolares,
        $bolivares,
        $activo,
        $porcentaje,
        $oferta_dolares,
        $oferta_bolivares
    )
    {
        $empresa = Empresa::find($this->empresas_id);
        $articulo = Articulo::find($articulos_id);
        $unidad = Unidad::find($unidades_id);
        $this->getStock['empresa'] = $empresa->nombre;
        $this->getStock['imagen'] = $articulo->detail;
        $this->getStock['vendido'] = $vendido;
        $this->getStock['unidad'] = $unidad->codigo;
        $this->getStock['articulo'] = $articulo->descripcion;
        $this->getStock['codigo'] = $articulo->codigo;
        $this->getStock['categoria'] = $articulo->categoria->nombre;
        $this->getStock['unidad_principal'] = $articulo->unidad->codigo;
        $this->getStock['tipo'] = $articulo->tipo->nombre;
        $this->getStock['procedencia'] = $articulo->procedencia->nombre;
        $this->getStock['tributario'] = $articulo->tributario->codigo;
        $this->getStock['taza'] = $articulo->tributario->taza;
        $this->getStock['marca'] = $articulo->marca;
        $this->getStock['modelo'] = $articulo->modelo;
        $this->getStock['referencia'] = $articulo->referencia;
        $this->getStock['articulo_estatus'] = $articulo->estatus;
        $this->getStock['estatus'] = $estatus;
        $this->getStock['existencias'] = json_decode($existencias);
        $this->getStock['dolares'] = $dolares;
        $this->getStock['bolivares'] = $bolivares;
        $this->getStock['activo'] = $activo;
        $this->getStock['porcentaje'] = $porcentaje;
        $this->getStock['oferta_dolares'] = $oferta_dolares;
        $this->getStock['oferta_bolivares'] = $oferta_bolivares;
    }

    #[On('showStock')]
    public function showStock()
    {

    }


}
