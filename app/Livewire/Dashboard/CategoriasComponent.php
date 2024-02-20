<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Categoria;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoriasComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $rows = 0;
    public $categorias_id, $codigo, $nombre, $photo, $keyword;
    public $verMini, $borrarIMG, $imagen;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $categorias = Categoria::buscar($this->keyword)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsCategorias = Categoria::count();

        return view('livewire.dashboard.categorias-component')
            ->with('listarCategorias', $categorias)
            ->with('rowsCategorias', $rowsCategorias)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 12) { $rows = 12; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('limpiarCategorias')]
    public function limpiarCategorias()
    {
        $this->reset([
            'categorias_id', 'codigo', 'nombre', 'photo', 'verMini', 'keyword',
            'borrarIMG', 'imagen'
        ]);
        $this->resetErrorBag();
    }

    public function updatedPhoto()
    {
        $messages = [
            'photo.max' => 'La imagen no debe ser mayor que 1024 kilobytes.'
        ];
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->imagen){
            $this->borrarIMG = $this->imagen;
        }
    }

    public function save()
    {
        $rules = [
            'codigo'       =>  ['required', 'min:4', 'max:8', 'alpha_dash:ascii', Rule::unique('categorias', 'codigo')->ignore($this->categorias_id)],
            'nombre'    =>  'required|min:4',
            'photo'     =>  'image|max:1024|nullable'
        ];
        $messages = [
            'codigo.required' => 'El codigo es obligatorio.',
            'codigo.min' => 'El codigo debe contener al menos 6 caracteres.',
            'codigo.max' => 'El codigo no debe ser mayor que 8 caracteres.',
            'codigo.alpha_num' => ' El codigo sólo debe contener letras y números.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe contener al menos 4 caracteres.',
            'photo.max' => 'La imagen no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->categorias_id)){
            //nuevo
            $categoria = new Categoria();
            $imagen = null;
            $message = "Categoria Creada.";
        }else{
            //editar
            $categoria = Categoria::find($this->categorias_id);
            $imagen = $categoria->imagen;
            $message = "Categoria Actualizada.";
        }
        $categoria->codigo = $this->codigo;
        $categoria->nombre = $this->nombre;

        if ($this->photo){
            $ruta = $this->photo->store('public/categorias');
            $categoria->imagen = str_replace('public/', 'storage/', $ruta);
            //miniaturas
            $nombre = explode('categorias/', $categoria->imagen);
            $path_data = "storage/categorias/size_".$nombre[1];
            $miniatura = crearMiniaturas($categoria->imagen, $path_data);
            $categoria->mini = $miniatura['mini'];
            $categoria->detail = $miniatura['detail'];
            $categoria->cart = $miniatura['cart'];
            $categoria->banner = $miniatura['banner'];
            //borramos imagenes anteriones si existen
            if ($this->borrarIMG){
                borrarImagenes($imagen, 'categorias');
            }
        }else{
            if ($this->borrarIMG){
                $categoria->imagen = null;
                $categoria->mini = null;
                $categoria->detail = null;
                $categoria->cart = null;
                $categoria->banner = null;
                borrarImagenes($this->borrarIMG, 'categorias');
            }
        }

        $categoria->save();
        $this->dispatch('listarSelect', tabla: 'categorias')->to(ArticulosComponent::class);
        $this->limpiarCategorias();
        $this->alert(
            'success',
            $message
        );


    }

    public function edit($id)
    {
        $this->reset('photo');
        $categoria = Categoria::find($id);
        $this->categorias_id = $categoria->id;
        $this->codigo = $categoria->codigo;
        $this->nombre = $categoria->nombre;
        $this->imagen = $categoria->imagen;
        $this->verMini = $categoria->mini;
        //$this->selectFormArticulos();
    }

    public function destroy($id)
    {
        $this->categorias_id = $id;
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

    #[On('confirmedCategorias')]
    public function confirmedCategorias()
    {
        $categoria = Categoria::find($this->categorias_id);
        $imagen = $categoria->imagen;

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $articulo = Articulo::where('categorias_id', $categoria->id)->first();
        if ($articulo){
            $vinculado = true;
        }

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
            borrarImagenes($imagen, 'categorias');
            $this->alert(
                'success',
                'Categoria Eliminada.'
            );

            $this->dispatch('listarSelect', tabla: 'categorias')->to(ArticulosComponent::class);
        }

        $this->limpiarCategorias();

    }

    public function buscar()
    {
        //
    }

    public function btnBorrarImgCategoria()
    {
        $this->verMini = null;
        $this->reset('photo');
        $this->borrarIMG = $this->imagen;
    }

}
