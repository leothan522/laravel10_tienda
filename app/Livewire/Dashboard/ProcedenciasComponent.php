<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Procedencia;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ProcedenciasComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;
    public $procedencias_id, $codigo, $nombre, $keyword;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $procedencias = Procedencia::buscar($this->keyword)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsProcedencias = Procedencia::count();
        return view('livewire.dashboard.procedencias-component')
            ->with('listarProcedencias', $procedencias)
            ->with('rowsProcedencias', $rowsProcedencias)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 12) { $rows = 12; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('limpiarProcedencias')]
    public function limpiarProcedencias()
    {
        $this->reset([
            'procedencias_id', 'codigo', 'nombre', 'keyword'
        ]);
        $this->resetErrorBag();
    }

    public function save()
    {
        $rules = [
            'codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('procedencias', 'codigo')->ignore($this->procedencias_id)],
            'nombre'    =>  'required|min:4',
        ];
        $messages = [
            'codigo.required' => 'El codigo es obligatorio.',
            'codigo.min' => 'El codigo debe contener al menos 6 caracteres.',
            'codigo.max' => 'El codigo no debe ser mayor que 8 caracteres.',
            'codigo.alpha_num' => ' El codigo sólo debe contener letras y números.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->procedencias_id)){
            //nuevo
            $procedencia = new Procedencia();
            $message = "Procedencia Creada.";
        }else{
            //editar
            $procedencia = Procedencia::find($this->procedencias_id);
            $message = "Procedencia Actualizada.";
        }
        $procedencia->codigo = $this->codigo;
        $procedencia->nombre = $this->nombre;

        $procedencia->save();
        $this->dispatch('listarSelect', tabla: 'procedencias')->to(ArticulosComponent::class);
        $this->limpiarProcedencias();
        $this->alert(
            'success',
            $message
        );


    }

    public function edit($id)
    {
        $procedencia = Procedencia::find($id);
        $this->procedencias_id = $procedencia->id;
        $this->codigo = $procedencia->codigo;
        $this->nombre = $procedencia->nombre;
    }

    public function destroy($id)
    {
        $this->procedencias_id = $id;
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

    #[On('confirmedProcedencias')]
    public function confirmedProcedencias()
    {
        $procedencia = Procedencia::find($this->procedencias_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $articulo = Articulo::where('procedencias_id', $procedencia->id)->first();
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
            $procedencia->delete();
            $this->alert(
                'success',
                'Procedencia Eliminada.'
            );
            $this->dispatch('listarSelect', tabla: 'procedencias')->to(ArticulosComponent::class);
        }

        $this->limpiarProcedencias();
    }

    public function buscar()
    {
        //
    }

}
