<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Precio;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StockComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'limpiarAlmacenes', 'confirmedAlmacenes'
    ];

    public $modulo_activo = false, $modulo_empresa, $modulo_articulo;
    public $empresa_id, $listarEmpresas, $empresa;
    public $listarStock, $getStock;
    public $almacen_id, $almacen_codigo, $almacen_nombre, $keywordAlmacenes;
    public $view = "stock";

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        if (numRowsPaginate() < 10){ $paginate = 10; }else{ $paginate = numRowsPaginate(); }

        $this->show();
        $this->getEmpresas();
        $almacenes = Almacen::buscar($this->keywordAlmacenes)->where('empresas_id', $this->empresa_id)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsAlmacenes = Almacen::count();

        return view('livewire.dashboard.stock-component')
            ->with('listarAlmacenes', $almacenes)
            ->with('rowsAlmacenes', $rowsAlmacenes);
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

    // ************************* Almacenes ********************************************

    public function limpiarAlmacenes()
    {
        $this->reset([
            'almacen_id', 'almacen_codigo', 'almacen_nombre', 'keywordAlmacenes'
        ]);
    }

    public function saveAlmacen()
    {
        $rules = [
            'almacen_codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('almacenes', 'codigo')->ignore($this->almacen_id)],
            'almacen_nombre'    =>  'required|min:4',
        ];
        $messages = [
            'almacen_codigo.required' => 'El campo codigo es obligatorio.',
            'almacen_codigo.min' => 'El campo codigo debe contener al menos 2 caracteres.',
            'almacen_codigo.max' => 'El campo codigo no debe ser mayor que 6 caracteres.',
            'almacen_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'almacen_nombre.required' => 'El campo nombre es obligatorio.',
            'almacen_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->almacen_id)){
            //nuevo
            $almacen = new Almacen();
            $message = "Almacen Creado.";
        }else{
            //editar
            $almacen = Almacen::find($this->almacen_id);
            $message = "Almacen Actualizado.";
        }
        $almacen->empresas_id = $this->empresa_id;
        $almacen->codigo = $this->almacen_codigo;
        $almacen->nombre = $this->almacen_nombre;
        $almacen->save();

        $this->editAlmacen($almacen->id);

        $this->alert(
            'success',
            $message
        );

    }

    public function editAlmacen($id)
    {
        $almacen = Almacen::find($id);
        $this->almacen_id = $almacen->id;
        $this->almacen_codigo = $almacen->codigo;
        $this->almacen_nombre = $almacen->nombre;
    }

    public function destroyAlmacen($id)
    {
        $this->almacen_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedAlmacenes',
        ]);

    }

    public function confirmedAlmacenes()
    {

        $almacen = Almacen::find($this->almacen_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;

        if ($vinculado) {
            $this->alert('warning', '¡No se puede Borrar!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'El registro que intenta borrar ya se encuentra vinculado con otros procesos.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);
        } else {
            $almacen->delete();
            $this->alert(
                'success',
                'Almacen Eliminado.'
            );
            $this->limpiarAlmacenes();
        }
    }

    public function buscarAlmacenes()
    {
        //
    }

    // ************************* Ajustes ********************************************

    public function verAjustes()
    {
        if ($this->view == "stock"){
            $this->view = "ajustes";
        }else{
            $this->view = "stock";
        }
    }

}
