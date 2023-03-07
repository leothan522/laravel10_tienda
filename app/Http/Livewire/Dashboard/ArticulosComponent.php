<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Categoria;
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
    protected $listeners = ['limpiarCategorias', 'confirmedCategorias'];

    public $categoria_id, $categoria_codigo, $categoria_nombre, $categoriaPhoto, $keywordCategorias;
    public $verMini;

    public function render()
    {
        if (numRowsPaginate() < 10){ $paginate = 10; }else{ $paginate = numRowsPaginate(); }
        $categorias = Categoria::buscar($this->keywordCategorias)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsCategorias = Categoria::count();
        return view('livewire.dashboard.articulos-component')
            ->with('listarCategorias', $categorias)
            ->with('rowsCategorias', $rowsCategorias);
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



}
