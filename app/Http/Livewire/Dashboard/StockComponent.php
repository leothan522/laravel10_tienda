<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Precio;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StockComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $modulo_activo = false, $modulo_empresa, $modulo_articulo;
    public $empresa_id, $listarEmpresas, $empresa;
    public $listarStock, $getStock;

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        $this->show();
        $this->getEmpresas();
        return view('livewire.dashboard.stock-component');
    }

    public function getEmpresaDefault()
    {
        if (comprobarPermisos(null)){
            $empresa = Empresa::where('default', 1)->first();
            if ($empresa){
                $this->empresa_id = $empresa->id;
            }
        }else{
            $empresas = Empresa::get();
            foreach ($empresas as $empresa){
                $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
                if ($acceso){
                    $this->empresa_id = $empresa->id;
                    break;
                }
            }
        }

        $this->modulo_empresa = Empresa::count();
        $this->modulo_articulo = Articulo::count();

        if ($this->modulo_empresa && $this->modulo_articulo && $this->empresa_id){
            $this->modulo_activo = true;
        }

    }

    public function getEmpresas()
    {
        $empresas = Empresa::get();
        $array = array();
        foreach ($empresas as $empresa){
            $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
            if ($acceso){
                array_push($array, $empresa);
            }
        }
        $this->listarEmpresas = dataSelect2($array);
    }

    public function show()
    {
        $empresa = Empresa::find($this->empresa_id);
        $this->empresa = $empresa;
        $stock = Stock::where('empresas_id', $this->empresa_id)->orderBy('actual', 'ASC')->get();
        $stock->each(function ($stock){
            $stock->activo = $stock->articulo->estatus;
            $resultado = calcularPrecios($stock->empresas_id, $stock->articulos_id, $stock->articulo->tributarios_id);
            $stock->moneda = $resultado['moneda_base'];
            $stock->dolares = $resultado['precio_dolares'];
            $stock->bolivares = $resultado['precio_bolivares'];
            $stock->iva_dolares = $resultado['iva_dolares'];
            $stock->iva_bolivares = $resultado['iva_bolivares'];
            $stock->neto_dolares = $resultado['neto_dolares'];
            $stock->neto_bolivares = $resultado['neto_bolivares'];
        });
        $this->listarStock = $stock;
    }

    public function setEstatus($id, $modal = false)
    {
        $stock = Stock::find($id);
        if ($stock->estatus == 1){
            $stock->estatus = 0;
        }else{
            $stock->estatus = 1;
        }
        $stock->update();
        if ($modal){
            $this->showModal($id);
        }
    }

    public function showModal($id)
    {
        $this->getStock = Stock::find($id);
        $this->getStock->activo = $this->getStock->articulo->estatus;
        $resultado = calcularPrecios($this->getStock->empresas_id, $this->getStock->articulos_id, $this->getStock->articulo->tributarios_id);
        $this->getStock->moneda = $resultado['moneda_base'];
        $this->getStock->dolares = $resultado['precio_dolares'];
        $this->getStock->bolivares = $resultado['precio_bolivares'];
        $this->getStock->iva_dolares = $resultado['iva_dolares'];
        $this->getStock->iva_bolivares = $resultado['iva_bolivares'];
        $this->getStock->neto_dolares = $resultado['neto_dolares'];
        $this->getStock->neto_bolivares = $resultado['neto_bolivares'];
    }

}
