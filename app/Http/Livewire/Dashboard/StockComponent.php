<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\Ajuste;
use App\Models\AjusTipo;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\ArtUnid;
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
        'changeEmpresa',
        'limpiarAlmacenes', 'confirmedAlmacenes',
        'limpiarTiposAjuste', 'confirmedTiposAjuste'
    ];

    public $modulo_activo = false, $modulo_empresa, $modulo_articulo;
    public $empresa_id, $listarEmpresas, $empresa;
    public $listarStock, $getStock;
    public $almacen_id, $almacen_codigo, $almacen_nombre, $keywordAlmacenes;
    public $tipos_ajuste_id, $tipos_ajuste_codigo, $tipos_ajuste_nombre, $tipos_ajuste_tipo = 1, $keywordTiposAjuste;
    public $view = "stock";
    public $view_ajustes = 'show', $footer = false, $new_ajuste = false, $btn_nuevo = true, $btn_editar = false, $btn_cancelar = false;
    public $ajuste_id, $ajuste_codigo, $ajuste_fecha, $ajuste_descripcion, $ajuste_contador = 1;
    public $ajusteTipo = [], $classTipo = [],
            $ajusteArticulo = [], $classArticulo = [], $ajusteDescripcion = [], $ajusteUnidad = [], $selectUnidad = [],
            $ajusteAlmacen = [], $classAlmacen = [], $ajusteCantidad = [],
            $ajuste_tipos_id = [], $ajuste_articulos_id = [], $ajuste_almacenes_id = [],
            $ajusteItem, $ajusteListarArticulos, $keywordAjustesArticulos;
    public $proximo_codigo;

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        if (numRowsPaginate() < 10){ $paginate = 10; }else{ $paginate = numRowsPaginate(); }
        $this->proximo_codigo = nextCodigoAjuste($this->empresa_id);
        $this->show();
        $this->getEmpresas();
        $almacenes = Almacen::buscar($this->keywordAlmacenes)->where('empresas_id', $this->empresa_id)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsAlmacenes = Almacen::count();
        $tiposAjuste = AjusTipo::buscar($this->keywordTiposAjuste)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsTiposAjuste = AjusTipo::count();

        return view('livewire.dashboard.stock-component')
            ->with('listarAlmacenes', $almacenes)
            ->with('rowsAlmacenes', $rowsAlmacenes)
            ->with('listarTiposAjuste', $tiposAjuste)
            ->with('rowsTiposAjuste', $rowsTiposAjuste);
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

    public function changeEmpresa()
    {
        $this->limpiarAjustes();
        $this->limpiarTiposAjuste();
        $this->limpiarAlmacenes();
    }

    //************************************ STOCK **************************************************

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

    // ************************* Tipos de AJuste ********************************************

    public function limpiarTiposAjuste()
    {
        $this->reset([
            'tipos_ajuste_id', 'tipos_ajuste_codigo', 'tipos_ajuste_nombre', 'tipos_ajuste_tipo', 'keywordTiposAjuste'
        ]);
    }

    public function saveTiposAjuste()
    {
        $rules = [
            'tipos_ajuste_codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('ajustes_tipos', 'codigo')->ignore($this->tipos_ajuste_id)],
            'tipos_ajuste_nombre'    =>  'required|min:4',
        ];
        $messages = [
            'tipos_ajuste_codigo.required' => 'El campo codigo es obligatorio.',
            'tipos_ajuste_codigo.min' => 'El campo codigo debe contener al menos 2 caracteres.',
            'tipos_ajuste_codigo.max' => 'El campo codigo no debe ser mayor que 6 caracteres.',
            'tipos_ajuste_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'tipos_ajuste_nombre.required' => 'El campo nombre es obligatorio.',
            'tipos_ajuste_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->tipos_ajuste_id)){
            //nuevo
            $tipo = new AjusTipo();
            $message = "Tipo de Ajuste Creado.";
        }else{
            //editar
            $tipo = AjusTipo::find($this->tipos_ajuste_id);
            $message = "Tipo de Ajuste Actualizado.";
        }
        $tipo->codigo = $this->tipos_ajuste_codigo;
        $tipo->descripcion = $this->tipos_ajuste_nombre;
        $tipo->tipo = $this->tipos_ajuste_tipo;
        $tipo->save();

        $this->editTiposAjuste($tipo->id);

        $this->alert(
            'success',
            $message
        );

    }

    public function editTiposAjuste($id)
    {
        $tipo = AjusTipo::find($id);
        $this->tipos_ajuste_id = $tipo->id;
        $this->tipos_ajuste_codigo = $tipo->codigo;
        $this->tipos_ajuste_nombre = $tipo->descripcion;
        $this->tipos_ajuste_tipo = $tipo->tipo;
    }

    public function destroyTiposAjuste($id)
    {
        $this->tipos_ajuste_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedTiposAjuste',
        ]);

    }

    public function confirmedTiposAjuste()
    {

        $tipo = AjusTipo::find($this->tipos_ajuste_id);

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
            $tipo->delete();
            $this->alert(
                'success',
                'Tipo de Ajuste Eliminado.'
            );
            $this->limpiarTiposAjuste();
        }
    }

    public function buscarTiposAjuste()
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

    public function limpiarAjustes()
    {
        $this->reset([
            'ajuste_id', 'view_ajustes', 'footer', 'new_ajuste', 'btn_nuevo', 'btn_editar', 'btn_cancelar',
            'ajuste_contador', 'ajuste_codigo', 'ajuste_descripcion', 'ajuste_fecha',
            'ajusteTipo', 'classTipo', 'ajusteArticulo', 'classArticulo', 'ajusteDescripcion', 'ajusteUnidad',
            'selectUnidad', 'ajusteAlmacen', 'ajusteCantidad', 'ajusteListarArticulos', 'keywordAjustesArticulos', 'ajusteItem',
            'ajuste_tipos_id', 'ajuste_articulos_id', 'ajuste_almacenes_id'
        ]);
        $this->resetErrorBag();
    }

    public function createAjuste()
    {
        $this->limpiarAjustes();
        $this->new_ajuste = true;
        $this->view_ajustes = "form";
        $this->btn_nuevo = false;
        $this->btn_cancelar = true;
        $this->btn_editar = false;
        $this->footer = false;
        $this->ajusteTipo[0] = null;
        $this->classTipo[0] = null;
        $this->ajusteArticulo[0] = null;
        $this->classArticulo[0] = null;
        $this->ajusteDescripcion[0] = null;
        $this->selectUnidad[0] = array();
        $this->ajusteUnidad[0] = null;
        $this->ajusteAlmacen[0] = null;
        $this->classAlmacen[0] = null;
        $this->ajusteCantidad[0] = null;
        $this->ajuste_fecha = date("Y-m-d");
    }

    public function btnCancelar()
    {
        if ($this->ajuste_id){
            //show ajuste
        }else{
            $this->limpiarAjustes();
        }
    }

    public function btnEditar()
    {
        $this->view_ajustes = 'form';
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->footer = false;
    }

    public function btnContador($opcion)
    {
        if ($opcion == "add"){
            $this->ajusteTipo[$this->ajuste_contador] = null;
            $this->classTipo[$this->ajuste_contador] = null;
            $this->ajusteArticulo[$this->ajuste_contador] = null;
            $this->classArticulo[$this->ajuste_contador] = null;
            $this->ajusteDescripcion[$this->ajuste_contador] = null;
            $this->selectUnidad[$this->ajuste_contador] = array();
            $this->ajusteUnidad[$this->ajuste_contador] = null;
            $this->ajusteAlmacen[$this->ajuste_contador] = null;
            $this->classAlmacen[$this->ajuste_contador] = null;
            $this->ajusteCantidad[$this->ajuste_contador] = null;
            $this->ajuste_contador++;
        }else{
            $this->ajuste_contador--;
            unset($this->ajusteTipo[$this->ajuste_contador]);
            unset($this->classTipo[$this->ajuste_contador]);
            unset($this->ajusteArticulo[$this->ajuste_contador]);
            unset($this->classArticulo[$this->ajuste_contador]);
            unset($this->ajusteDescripcion[$this->ajuste_contador]);
            unset($this->selectUnidad[$this->ajuste_contador]);
            unset($this->ajusteUnidad[$this->ajuste_contador]);
            unset($this->ajusteAlmacen[$this->ajuste_contador]);
            unset($this->classAlmacen[$this->ajuste_contador]);
            unset($this->ajusteCantidad[$this->ajuste_contador]);
        }
    }

    protected function rules(){
        return [
            'ajuste_codigo'         =>  ['nullable', 'min:4', 'alpha_num:ascii', Rule::unique('ajustes', 'codigo')->ignore($this->ajuste_id)],
            'ajuste_fecha'          => 'required',
            'ajuste_descripcion'    => 'required|min:4',
            'ajusteTipo.*'          => ['required', Rule::exists('ajustes_tipos', 'codigo')],
            'ajusteArticulo.*'      => ['required', Rule::exists('articulos', 'codigo')],
            'ajusteUnidad.*'        =>  'required',
            'ajusteAlmacen.*'       => ['required', Rule::exists('almacenes', 'codigo')],
            'ajusteCantidad.*'      =>  'required'
        ];
    }

    public function saveAjustes()
    {

        $this->validate();

        if (empty($this->ajuste_codigo)){
            $this->ajuste_codigo = $this->proximo_codigo['formato'] . cerosIzquierda($this->proximo_codigo['proximo'], numSizeCodigo());
        }

        $ajuste = new Ajuste();
        $ajuste->empresas_id = $this->empresa_id;
        $ajuste->codigo = $this->ajuste_codigo;
        $ajuste->descripcion = $this->ajuste_descripcion;
        $ajuste->fecha = $this->ajuste_fecha;
        $ajuste->save();

        for ($i = 0; $i < $this->ajuste_contador; $i++){
            $detalles = new AjusDetalle();
            $detalles->ajustes_id = $ajuste->id;
            $detalles->tipos_id = $this->ajuste_tipos_id[$i];
            $detalles->articulos_id = $this->ajuste_articulos_id[$i];
            $detalles->almacenes_id = $this->ajuste_almacenes_id[$i];
            $detalles->unidades_id = $this->ajusteUnidad[$i];
            $detalles->cantidad = $this->ajusteCantidad[$i];
            $detalles->save();
        }



        $this->alert('success', 'Hola');
    }

    public function updatedAjusteTipo()
    {
        foreach ($this->ajusteTipo as $key => $value){
            if ($value){
                $tipo = AjusTipo::where('codigo', $value)->first();
                if ($tipo){
                    $this->ajuste_tipos_id[$key] = $tipo->id;
                    $this->classTipo[$key] = "is-valid";
                    $this->resetErrorBag('ajusteTipo.'.$key);
                }else{
                    $this->classTipo[$key] = "is-invalid";
                    $this->ajuste_tipos_id[$key] = null;
                }
            }
        }
    }

    public function updatedAjusteArticulo()
    {
        foreach ($this->ajusteArticulo as $key => $value){
            $array = array();
            if ($value){
                $articulo = Articulo::where('codigo', $value)->where('estatus', 1)->first();
                if ($articulo && !empty($articulo->unidades_id)){
                    $array[] = [
                        'id'        => $articulo->unidades_id,
                        'codigo'    => $articulo->unidad->codigo
                    ];
                    $unidades = ArtUnid::where('articulos_id', $articulo->id)->get();
                    foreach ($unidades as $unidad){
                        $array[] = [
                            'id'        => $unidad->unidades_id,
                            'codigo'    => $unidad->unidad->codigo
                        ];
                    }
                    $this->ajusteDescripcion[$key] = $articulo->descripcion;
                    $this->selectUnidad[$key] = $array;
                    if (is_null($this->ajusteUnidad[$key])){
                        $this->ajusteUnidad[$key] = $articulo->unidades_id;
                    }
                    $this->resetErrorBag('ajusteArticulo.'.$key);
                    $this->resetErrorBag('ajusteUnidad.'.$key);
                    $this->ajuste_articulos_id[$key] = $articulo->id;
                    $this->classArticulo[$key] = "is-valid";
                }else{
                    $this->classArticulo[$key] = "is-invalid";
                    $this->ajusteDescripcion[$key] = null;
                    $this->ajuste_articulos_id[$key] = null;
                    $this->selectUnidad[$key] = array();
                    $this->ajusteUnidad[$key] = null;
                }
            }
        }
    }

    public function updatedAjusteAlmacen()
    {
        foreach ($this->ajusteAlmacen as $key => $value){
            if ($value){
                $almacen = Almacen::where('codigo', $value)->where('empresas_id', $this->empresa_id)->first();
                if ($almacen){
                    $this->resetErrorBag('ajusteAlmacen.'.$key);
                    $this->ajuste_almacenes_id[$key] = $almacen->id;
                    $this->classAlmacen[$key] = "is-valid";
                }else{
                    $this->ajuste_almacenes_id[$key] = null;
                    $this->classAlmacen[$key] = "is-invalid";
                }
            }
        }
    }

    public function itemTemporalAjuste($int)
    {
        $this->ajusteItem = $int;
    }

    public function buscarAjustesArticulos()
    {
        $this->ajusteListarArticulos = Articulo::buscar($this->keywordAjustesArticulos)->where('estatus', 1)->limit(100)->get();
    }

    public function selectArticuloAjuste($codigo)
    {
         $this->ajusteArticulo[$this->ajusteItem] = $codigo;
         $this->updatedAjusteArticulo();
    }

}
