<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Categoria;
use App\Models\Procedencia;
use App\Models\Unidad;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ArticulosComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'limpiarCategorias', 'confirmedCategorias',
        'limpiarUnidades', 'confirmedUnidades',
        'limpiarProcedencias', 'confirmedProcedencias'
    ];

    public $categoria_id, $categoria_codigo, $categoria_nombre, $categoriaPhoto, $keywordCategorias;
    public $unidad_id, $unidad_codigo, $unidad_nombre, $keywordUnidades;
    public $procedencia_id, $procedencia_codigo, $procedencia_nombre, $keywordProcedencias;
    public $verMini;

    public function render()
    {
        if (numRowsPaginate() < 10){ $paginate = 10; }else{ $paginate = numRowsPaginate(); }
        $categorias = Categoria::buscar($this->keywordCategorias)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsCategorias = Categoria::count();
        $unidades = Unidad::buscar($this->keywordUnidades)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsUnidades = Unidad::count();
        $procedencias = Procedencia::buscar($this->keywordProcedencias)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsProcedencias = Procedencia::count();
        return view('livewire.dashboard.articulos-component')
            ->with('listarCategorias', $categorias)
            ->with('rowsCategorias', $rowsCategorias)
            ->with('listarUnidades', $unidades)
            ->with('rowsUnidades', $rowsUnidades)
            ->with('listarProcedencias', $procedencias)
            ->with('rowsProcedencias', $rowsProcedencias)
            ;
    }

    public function limpiarCategorias()
    {
        $this->reset([
            'categoria_id', 'categoria_codigo', 'categoria_nombre', 'categoriaPhoto', 'verMini', 'keywordCategorias'
        ]);
    }

    public function updatedCategoriaPhoto()
    {
        $messages = [
            'categoriaPhoto.max' => 'El campo imagen no debe ser mayor que 1024 kilobytes.'
        ];
        $this->validate([
            'categoriaPhoto' => 'image|max:1024', // 1MB Max
        ], $messages);
    }

    public function saveCategoria()
    {
        $rules = [
            'categoria_codigo'       =>  ['required', 'min:6', 'max:8', 'alpha_num:ascii', Rule::unique('categorias', 'codigo')->ignore($this->categoria_id)],
            'categoria_nombre'    =>  'required|min:4',
            'categoriaPhoto'     =>  'image|max:1024|nullable'
        ];
        $messages = [
            'categoria_codigo.required' => 'El campo codigo es obligatorio.',
            'categoria_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'categoria_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'categoria_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'categoria_nombre.required' => 'El campo nombre es obligatorio.',
            'categoria_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.',
            'categoriaPhoto.max' => 'El campo imagen no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->categoria_id)){
            //nuevo
            $categoria = new Categoria();
            $message = "Categoria Creada.";
        }else{
            //editar
            $categoria = Categoria::find($this->categoria_id);
            $message = "Categoria Actualizada.";
        }
        $categoria->codigo = $this->categoria_codigo;
        $categoria->nombre = $this->categoria_nombre;

        if ($this->categoriaPhoto){
            $ruta = $this->categoriaPhoto->store('public/categorias');
            $categoria->imagen = str_replace('public/', 'storage/', $ruta);
            //miniaturas
            $nombre = explode('categorias/', $categoria->imagen);
            $path_data = "storage/categorias/size_".$nombre[1];
            $miniatura = crearMiniaturas($categoria->imagen, $path_data);
            $categoria->mini = $miniatura['mini'];
            $categoria->detail = $miniatura['detail'];
            $categoria->cart = $miniatura['cart'];
            $categoria->banner = $miniatura['banner'];
        }

        $categoria->save();
        $this->editCategoria($categoria->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editCategoria($id)
    {
        $categoria = Categoria::find($id);
        $this->categoria_id = $categoria->id;
        $this->categoria_codigo = $categoria->codigo;
        $this->categoria_nombre = $categoria->nombre;
        $this->verMini = $categoria->mini;
    }

    public function destroyCategoria($id)
    {
        $this->categoria_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedCategorias',
        ]);
    }

    public function confirmedCategorias()
    {
        $categoria = Categoria::find($this->categoria_id);

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
            $categoria->delete();
            $this->alert(
                'success',
                'Categoria Eliminada.'
            );
            $this->limpiarCategorias();
        }
    }

    public function buscarCategoria()
    {
        //
    }

    public function limpiarUnidades()
    {
        $this->reset([
            'unidad_id', 'unidad_codigo', 'unidad_nombre', 'keywordUnidades'
        ]);
    }

    public function saveUnidad()
    {
        $rules = [
            'unidad_codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('unidades', 'codigo')->ignore($this->unidad_id)],
            'unidad_nombre'    =>  'required|min:4',
        ];
        $messages = [
            'unidad_codigo.required' => 'El campo codigo es obligatorio.',
            'unidad_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'unidad_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'unidad_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'unidad_nombre.required' => 'El campo nombre es obligatorio.',
            'unidad_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->unidad_id)){
            //nuevo
            $unidad = new Unidad();
            $message = "Unidad Creada.";
        }else{
            //editar
            $unidad = Unidad::find($this->unidad_id);
            $message = "Unidad Actualizada.";
        }
        $unidad->codigo = $this->unidad_codigo;
        $unidad->nombre = $this->unidad_nombre;

        $unidad->save();
        $this->editUnidad($unidad->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editUnidad($id)
    {
        $unidad = Unidad::find($id);
        $this->unidad_id = $unidad->id;
        $this->unidad_codigo = $unidad->codigo;
        $this->unidad_nombre = $unidad->nombre;
    }

    public function destroyUnidad($id)
    {
        $this->unidad_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedUnidades',
        ]);
    }

    public function confirmedUnidades()
    {
        $unidad = Unidad::find($this->unidad_id);

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
            $unidad->delete();
            $this->alert(
                'success',
                'Unidad Eliminada.'
            );
            $this->limpiarUnidades();
        }
    }

    public function buscarUnidades()
    {
        //
    }

    public function limpiarProcedencias()
    {
        $this->reset([
            'procedencia_id', 'procedencia_codigo', 'procedencia_nombre', 'keywordProcedencias'
        ]);
    }

    public function saveProcedencia()
    {
        $rules = [
            'procedencia_codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('procedencias', 'codigo')->ignore($this->procedencia_id)],
            'procedencia_nombre'    =>  'required|min:4',
        ];
        $messages = [
            'procedencia_codigo.required' => 'El campo codigo es obligatorio.',
            'procedencia_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'procedencia_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'procedencia_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'procedencia_nombre.required' => 'El campo nombre es obligatorio.',
            'procedencia_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->procedencia_id)){
            //nuevo
            $procedencia = new Procedencia();
            $message = "Procedencia Creada.";
        }else{
            //editar
            $procedencia = Procedencia::find($this->procedencia_id);
            $message = "Procedencia Actualizada.";
        }
        $procedencia->codigo = $this->procedencia_codigo;
        $procedencia->nombre = $this->procedencia_nombre;

        $procedencia->save();
        $this->editProcedencia($procedencia->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editProcedencia($id)
    {
        $procedencia = Procedencia::find($id);
        $this->procedencia_id = $procedencia->id;
        $this->procedencia_codigo = $procedencia->codigo;
        $this->procedencia_nombre = $procedencia->nombre;
    }

    public function destroyProcedencia($id)
    {
        $this->procedencia_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedProcedencias',
        ]);
    }

    public function confirmedProcedencias()
    {
        $procedencia = Procedencia::find($this->procedencia_id);

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
            $procedencia->delete();
            $this->alert(
                'success',
                'Procedencia Eliminada.'
            );
            $this->limpiarProcedencias();
        }
    }

    public function buscarProcedencias()
    {
        //
    }



}
