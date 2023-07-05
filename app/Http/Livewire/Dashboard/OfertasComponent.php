<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class OfertasComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'changeEmpresa', 'setSelectForm', 'categoriaSeleccionada', 'articuloSeleccionado', 'oferta_id',
        'setEdit', 'confirmed'
    ];

    public $modulo_activo = false, $modulo_empresa, $modulo_articulo;
    public $empresa_id, $listarEmpresas, $empresa, $keyword;
    public $afectados, $categorias_id, $articulos_id, $desde, $hasta, $descuento, $oferta_id;

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        if (numRowsPaginate() < 10) {
            $paginate = 10;
        } else {
            $paginate = numRowsPaginate();
        }

        $empresa = Empresa::find($this->empresa_id);
        $this->empresa = $empresa;

        $this->getEmpresas();

        $listarCategorias = Categoria::orderBy('codigo', 'ASC')->get();
        $listarArticulos = Articulo::where('estatus', 1)->orderBy('codigo', 'ASC')->get();

        $listarOfertas = Oferta::where('empresas_id', $this->empresa_id)->orderBy('id', 'desc')->paginate($paginate);
        $rowsOfertas = Oferta::where('empresas_id', $this->empresa_id)->count();


        return view('livewire.dashboard.ofertas-component')
            ->with('listarCategorias' , $listarCategorias)
            ->with('listarArticulos' , $listarArticulos)
            ->with('listarOfertas', $listarOfertas)
            ->with('rowsOfertas', $rowsOfertas)
            ;
    }

    public function getEmpresaDefault()
    {
        if (comprobarPermisos(null)) {
            $empresa = Empresa::where('default', 1)->first();
            if ($empresa) {
                $this->empresa_id = $empresa->id;
            }
        } else {
            $empresas = Empresa::get();
            foreach ($empresas as $empresa) {
                $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
                if ($acceso) {
                    $this->empresa_id = $empresa->id;
                    break;
                }
            }
        }

        $this->modulo_empresa = Empresa::count();
        $this->modulo_articulo = Articulo::count();

        if ($this->modulo_empresa && $this->modulo_articulo && $this->empresa_id) {
            $this->modulo_activo = true;
        }

    }

    public function getEmpresas()
    {
        $empresas = Empresa::get();
        $array = array();
        foreach ($empresas as $empresa) {
            $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
            if ($acceso) {
                array_push($array, $empresa);
            }
        }
        $this->listarEmpresas = dataSelect2($array);
    }

    public function changeEmpresa()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->reset([
            'afectados', 'categorias_id', 'articulos_id', 'desde', 'hasta', 'descuento', 'oferta_id'
        ]);
        $this->emit('setEdit', null, null);
    }

    public function rules()
    {
        return [
            'afectados'    =>  'required',
            'categorias_id'      =>  'required_if:afectados,1',
            'articulos_id'    =>  'required_if:afectados,2',
            'desde' =>  'required',
            'hasta'     =>  'required_with:desde|after:desde',
            'descuento' =>  'required',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->oferta_id){
            //editar
            $oferta = Oferta::find($this->oferta_id);
            $message = "Cambios Guardados.";
        }else{
            //nuevo
            $oferta = new Oferta();
            $message = "Oferca Creada Exitosamente.";
        }

        $oferta->empresas_id = $this->empresa_id;
        $oferta->afectados = $this->afectados;
        if ($this->categorias_id){
            $oferta->categorias_id = $this->categorias_id;
        }
        if ($this->articulos_id){
            $oferta->articulos_id = $this->articulos_id;
        }

        $oferta->desde = $this->desde;
        $oferta->hasta = $this->hasta;
        $oferta->descuento = $this->descuento;
        $oferta->save();

        $this->limpiar();

        $this->alert(
            'success',
            $message);
    }

    public function edit($id)
    {
        $this->limpiar();
        $oferta = Oferta::find($id);
        $this->oferta_id = $oferta->id;
        $this->afectados = $oferta->afectados;
        $this->categorias_id = $oferta->categorias_id;
        $this->articulos_id = $oferta->articulos_id;
        $this->desde = $oferta->desde;
        $this->hasta = $oferta->hasta;
        $this->descuento = $oferta->descuento;
        $this->emit('setEdit', $this->categorias_id, $this->articulos_id);
    }

    public function destroy($id)
    {
        $this->oferta_id = $id;

        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
        ]);
    }

    public function confirmed()
    {
        $oferta = Oferta::find($this->oferta_id);

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
            $oferta->delete();
            $this->alert(
                'success',
                'Oferta Eliminada.'
            );
            $this->limpiar();
        }
    }

    public function setSelectForm($categorias, $articulos)
    {
        //select categorias formulario articulos
    }

    public function categoriaSeleccionada($id)
    {
        $this->categorias_id = $id;
    }

    public function articuloSeleccionado($id)
    {
        $this->articulos_id = $id;
    }

    public function setEdit($categoria, $articulo)
    {
        //select JS EDIT
    }

}
