<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\Ajuste;
use App\Models\AjusTipo;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\ArtUnid;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\Precio;
use App\Models\Stock;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $getStock = [];
    public $almacen_id, $almacen_codigo, $almacen_nombre, $keywordAlmacenes;
    public $tipos_ajuste_id, $tipos_ajuste_codigo, $tipos_ajuste_nombre, $tipos_ajuste_tipo = 1, $keywordTiposAjuste;
    public $view = "stock";
    public $view_ajustes = 'show', $footer = false, $new_ajuste = false, $btn_nuevo = true, $btn_editar = false, $btn_cancelar = false;
    public $ajuste_id, $ajuste_codigo, $ajuste_fecha, $ajuste_descripcion, $ajuste_contador = 1, $listarDetalles;
    public $ajusteTipo = [], $classTipo = [],
            $ajusteArticulo = [], $classArticulo = [], $ajusteDescripcion = [], $ajusteUnidad = [], $selectUnidad = [],
            $ajusteAlmacen = [], $classAlmacen = [], $ajusteCantidad = [],
            $ajuste_tipos_id = [], $ajuste_articulos_id = [], $ajuste_almacenes_id = [], $ajuste_tipos_tipo = [], $ajuste_almacenes_tipo = [],
            $ajusteItem, $ajusteListarArticulos, $keywordAjustesArticulos, $detallesItem;
    public $proximo_codigo;

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        if (numRowsPaginate() < 10){ $paginate = 10; }else{ $paginate = numRowsPaginate(); }
        $this->proximo_codigo = nextCodigoAjuste($this->empresa_id);

        $empresa = Empresa::find($this->empresa_id);
        $this->empresa = $empresa;

        $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id', 'estatus'])
            ->groupBy('empresas_id', 'articulos_id', 'unidades_id', 'estatus')
            ->having('empresas_id', $this->empresa_id)
            ->orderBy('articulos_id', 'asc')
            ->paginate(100);
        $stock->each(function ($stock){

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

            $existencias = Stock::where('empresas_id', $stock->empresas_id)
                ->where('articulos_id', $articulo->id)
                ->where('unidades_id', $unidad->id)
                ->get();
            $array = array();
            $actual = 0;
            $comprometido = 0;
            $disponible = 0;
            $vendido = 0;
            foreach ($existencias as $existencia){
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
            $stock->compometido = $comprometido;
            $stock->disponible = $disponible;
            $stock->existencias = $array;
            $stock->vendido = $vendido;

        });

        //dd($stock);


        $this->getEmpresas();
        $almacenes = Almacen::buscar($this->keywordAlmacenes)->where('empresas_id', $this->empresa_id)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsAlmacenes = Almacen::count();
        $tiposAjuste = AjusTipo::buscar($this->keywordTiposAjuste)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsTiposAjuste = AjusTipo::count();
        $ajustes = Ajuste::where('empresas_id', $this->empresa_id)->orderBy('codigo', 'desc')->paginate($paginate);
        return view('livewire.dashboard.stock-component')
            ->with('listarAlmacenes', $almacenes)
            ->with('rowsAlmacenes', $rowsAlmacenes)
            ->with('listarTiposAjuste', $tiposAjuste)
            ->with('rowsTiposAjuste', $rowsTiposAjuste)
            ->with('listarAjustes', $ajustes)
            ->with('listarStock', $stock);
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

    public function changeEmpresa()
    {
        $this->limpiarAjustes();
        $this->limpiarTiposAjuste();
        $this->limpiarAlmacenes();
        $this->reset([
            'ajuste_id'
        ]);
    }

    //************************************ STOCK **************************************************

    public function show()
    {
        $this->reset([
            'getStock'
        ]);
    }

    public function setEstatus($existencias)
    {
        foreach (json_decode($existencias) as $existencia){
            $stock = Stock::find($existencia->id);
            if ($stock->estatus == 1){
                $stock->estatus = 0;
            }else{
                $stock->estatus = 1;
            }
            $stock->update();
        }
    }

    public function showModal($articulos_id, $unidades_id, $vendido, $estatus, $existencias, $dolares, $bolivares, $activo)
    {
        $empresa = Empresa::find($this->empresa_id);
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
        $this->getStock['estatus'] = $estatus;
        $this->getStock['existencias'] = json_decode($existencias);
        $this->getStock['dolares'] = $dolares;
        $this->getStock['bolivares'] = $bolivares;
        $this->getStock['activo'] = $activo;
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
            if ($this->ajuste_id){
                $this->showAjustes($this->ajuste_id);
            }else{
                $this->limpiarAjustes();
            }
            $this->view = "ajustes";
        }else{
            $this->view = "stock";
        }
    }

    public function limpiarAjustes()
    {
        $this->reset([
            'view_ajustes', 'footer', 'new_ajuste', 'btn_nuevo', 'btn_editar', 'btn_cancelar',
            'ajuste_contador', 'ajuste_codigo', 'ajuste_descripcion', 'ajuste_fecha',
            'ajusteTipo', 'classTipo', 'ajusteArticulo', 'classArticulo', 'ajusteDescripcion', 'ajusteUnidad',
            'selectUnidad', 'ajusteAlmacen', 'ajusteCantidad', 'ajusteListarArticulos', 'keywordAjustesArticulos', 'ajusteItem',
            'ajuste_tipos_id', 'ajuste_articulos_id', 'ajuste_almacenes_id', 'tipos_ajuste_tipo', 'ajuste_almacenes_tipo',
            'listarDetalles', 'detallesItem'
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
    }

    public function btnCancelar()
    {
        $this->limpiarAjustes();
        if ($this->ajuste_id){
            //show ajuste
            $this->showAjustes($this->ajuste_id);
        }
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

            for ($i = $opcion; $i < $this->ajuste_contador - 1; $i++){
                $this->ajusteTipo[$i] = $this->ajusteTipo[$i + 1];
                $this->classTipo[$i] = $this->classTipo[$i + 1];
                $this->ajusteArticulo[$i] = $this->ajusteArticulo[$i + 1];
                $this->classArticulo[$i] = $this->classArticulo[$i + 1];
                $this->ajusteDescripcion[$i] = $this->ajusteDescripcion[$i + 1];
                $this->selectUnidad[$i] = $this->selectUnidad[$i + 1];
                $this->ajusteUnidad[$i] = $this->ajusteUnidad[$i + 1];
                $this->ajusteAlmacen[$i] = $this->ajusteAlmacen[$i + 1];
                $this->classAlmacen[$i] = $this->classAlmacen[$i + 1];
                $this->ajusteCantidad[$i] = $this->ajusteCantidad[$i + 1];
            }

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
            'ajuste_codigo'         =>  ['nullable', 'min:4', 'alpha_num:ascii', Rule::unique('ajustes', 'codigo')/*->ignore($this->ajuste_id)*/],
            'ajuste_fecha'          => 'nullable',
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

        if (empty($this->ajuste_fecha)){
            $this->ajuste_fecha = date("Y-m-d H:i:s");
        }

        $procesar = true;
        $html = null;

        for ($i = 0; $i < $this->ajuste_contador; $i++){
            if ($this->ajuste_tipos_tipo[$i] == 2){
                $stock = Stock::where('empresas_id', $this->empresa_id)
                    ->where('articulos_id', $this->ajuste_articulos_id[$i])
                    ->where('almacenes_id', $this->ajuste_almacenes_id[$i])
                    ->where('unidades_id', $this->ajusteUnidad[$i])
                    ->first();
                if ($stock){
                    $disponible = $stock->disponible;
                    if ($this->ajusteCantidad[$i] > $disponible){
                        $procesar = false;
                        $html .= 'Para <strong>'.formatoMillares($this->ajusteCantidad[$i], 3).'</strong> del articulo <strong>'.$this->ajusteArticulo[$i].'</strong>. el stock actual es <strong>'.formatoMillares($disponible, 3).'</strong><br>';
                        $this->addError('ajusteCantidad.'.$i, 'error');
                    }
                }else{
                    $procesar = false;
                    $html .= 'Para <strong>'.formatoMillares($this->ajusteCantidad[$i],3).'</strong> del articulo <strong>'.$this->ajusteArticulo[$i].'</strong>. el stock actual es <strong>0,000</strong><br>';
                    $this->addError('ajusteCantidad.'.$i, 'error');
                }
            }
        }

        if ($procesar){

            $ajuste = new Ajuste();
            $ajuste->empresas_id = $this->empresa_id;
            $ajuste->codigo = $this->ajuste_codigo;
            $ajuste->descripcion = $this->ajuste_descripcion;
            $ajuste->fecha = $this->ajuste_fecha;
            $ajuste->save();

            $parametro = Parametro::find($this->proximo_codigo['id']);
            $parametro->valor++;
            $parametro->save();

            for ($i = 0; $i < $this->ajuste_contador; $i++){
                $detalles = new AjusDetalle();
                $detalles->ajustes_id = $ajuste->id;
                $detalles->tipos_id = $this->ajuste_tipos_id[$i];
                $detalles->articulos_id = $this->ajuste_articulos_id[$i];
                $detalles->almacenes_id = $this->ajuste_almacenes_id[$i];
                $detalles->unidades_id = $this->ajusteUnidad[$i];
                $detalles->cantidad = $this->ajusteCantidad[$i];
                $detalles->save();
                $exite = Stock::where('empresas_id', $this->empresa_id)
                    ->where('articulos_id', $this->ajuste_articulos_id[$i])
                    ->where('almacenes_id', $this->ajuste_almacenes_id[$i])
                    ->where('unidades_id', $this->ajusteUnidad[$i])
                    ->first();
                if ($exite){
                    //edito
                    $stock = Stock::find($exite->id);
                    $compometido = $stock->comprometido;
                    $disponible = $stock->disponible;
                    if ($this->ajuste_tipos_tipo[$i] == 1){
                        //sumo entrada
                        $stock->disponible = $disponible + $this->ajusteCantidad[$i];
                    }else{
                        //resto salida
                        $stock->disponible = $disponible - $this->ajusteCantidad[$i];
                    }
                    $stock->actual = $compometido + $stock->disponible;
                    $stock->save();
                }else{
                    //nuevo
                    $stock = new Stock();
                    $stock->empresas_id = $this->empresa_id;
                    $stock->articulos_id = $this->ajuste_articulos_id[$i];
                    $stock->almacenes_id = $this->ajuste_almacenes_id[$i];
                    $stock->unidades_id = $this->ajusteUnidad[$i];
                    $stock->actual = $this->ajusteCantidad[$i];
                    $stock->comprometido = 0;
                    $stock->disponible = $this->ajusteCantidad[$i];
                    $stock->vendido = 0;
                    $stock->almacen_principal = $this->ajuste_almacenes_tipo[$i];
                    $stock->save();
                }
            }
            $this->showAjustes($ajuste->id);
            $this->alert('success', 'Ajuste Guardado Correctamente.');
        }else{
            $this->alert('warning', '¡Stock Insuficiente!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'html' => $html,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);
        }



    }

    public function updatedAjusteTipo()
    {
        foreach ($this->ajusteTipo as $key => $value){
            if ($value){
                $tipo = AjusTipo::where('codigo', $value)->first();
                if ($tipo){
                    $this->ajuste_tipos_id[$key] = $tipo->id;
                    $this->ajuste_tipos_tipo[$key] = $tipo->tipo;
                    $this->classTipo[$key] = "is-valid";
                    $this->resetErrorBag('ajusteTipo.'.$key);
                }else{
                    $this->classTipo[$key] = "is-invalid";
                    $this->ajuste_tipos_id[$key] = null;
                    $this->ajuste_tipos_tipo[$key] = null;
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
                    $this->ajuste_almacenes_tipo[$key] = $almacen->tipo;
                    $this->classAlmacen[$key] = "is-valid";
                }else{
                    $this->ajuste_almacenes_id[$key] = null;
                    $this->ajuste_almacenes_tipo[$key] = null;
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

    public function showAjustes($id)
    {
        $this->limpiarAjustes();
        $this->ajuste_id = $id;
        $this->btn_editar = true;
        $this->footer = true;
        $ajuste = Ajuste::find($this->ajuste_id);
        $this->ajuste_codigo = $ajuste->codigo;
        $this->ajuste_fecha = $ajuste->fecha;
        $this->ajuste_descripcion = $ajuste->descripcion;
        $this->listarDetalles = AjusDetalle::where('ajustes_id', $this->ajuste_id)->get();
        $this->ajuste_contador = AjusDetalle::where('ajustes_id', $this->ajuste_id)->count();
    }

    public function btnEditar()
    {
        $this->view_ajustes = 'form';
        $this->new_ajuste = false;
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->footer = false;

        $i = 0;
        foreach ($this->listarDetalles as $detalle){
            $array = array();
            $array[] = [
                'id'        => $detalle->articulo->unidades_id,
                'codigo'    => $detalle->articulo->unidad->codigo
            ];
            $unidades = ArtUnid::where('articulos_id', $detalle->articulos_id)->get();
            foreach ($unidades as $unidad){
                $array[] = [
                    'id'        => $unidad->unidades_id,
                    'codigo'    => $unidad->unidad->codigo
                ];
            }
            $this->ajusteTipo[$i] = $detalle->tipo->codigo;
            $this->classTipo[$i] = null;
            $this->ajusteArticulo[$i] = $detalle->articulo->codigo;
            $this->classArticulo[$i] = null;
            $this->ajusteDescripcion[$i] = $detalle->articulo->descripcion;
            $this->selectUnidad[$i] = $array;
            $this->ajusteUnidad[$i] = $detalle->unidades_id;
            $this->ajusteAlmacen[$i] = $detalle->almacen->codigo;
            $this->classAlmacen[$i] = null;
            $this->ajusteCantidad[$i] = $detalle->cantidad;
            $i++;
        }
    }

}
