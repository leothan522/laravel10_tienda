<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\TipoArticulo;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class TiposComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;
    public $tipos_id, $nombre, $keyword;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $tipos = TipoArticulo::buscar($this->keyword)
            ->limit($this->rows)
            ->get()
        ;
        $rowsTipos = TipoArticulo::count();
        return view('livewire.dashboard.tipos-component')
            ->with('listarTipos', $tipos)
            ->with('rowsTipos', $rowsTipos)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 12) { $rows = 12; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('limpiarTipos')]
    public function limpiarTipos()
    {
        $this->reset([
            'tipos_id', 'nombre', 'keyword'
        ]);
        $this->resetErrorBag();
    }

    public function save()
    {
        $rules = [
            'nombre'       =>  ['required', 'min:4', 'max:10', 'alpha_num:ascii', Rule::unique('articulos_tipo', 'nombre')->ignore($this->tipos_id)],
        ];
        $messages = [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.',
            'nombre.max' => 'El campo codigo no debe ser mayor que 10 caracteres.',
            'nombre.alpha_num' => ' El campo nombre sólo debe contener letras y números.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->tipos_id)){
            //nuevo
            $tipo = new TipoArticulo();
            $message = "Tipo Creado.";
        }else{
            //editar
            $tipo = TipoArticulo::find($this->tipos_id);
            $message = "Tipo Actualizado.";
        }
        $tipo->nombre = $this->nombre;

        $tipo->save();
        $this->dispatch('listarSelect', tabla: 'tipos')->to(ArticulosComponent::class);
        $this->limpiarTipos();
        $this->alert(
            'success',
            $message
        );


    }

    public function edit($id)
    {
        $tipo = TipoArticulo::find($id);
        $this->tipos_id = $tipo->id;
        $this->nombre = $tipo->nombre;
    }

    public function destroy($id)
    {
        $this->tipos_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedTipos',
        ]);
    }

    #[On('confirmedTipos')]
    public function confirmedTipos()
    {
        $tipo = TipoArticulo::find($this->tipos_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $articulo = Articulo::where('tipos_id', $tipo->id)->first();
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
            $tipo->delete();
            $this->alert(
                'success',
                'Tipo Eliminado.'
            );
            $this->dispatch('listarSelect', tabla: 'tipos')->to(ArticulosComponent::class);
        }

        $this->limpiarTipos();
    }

    public function buscar()
    {
        //
    }

}
