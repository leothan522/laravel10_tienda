<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Unidad;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class UnidadesComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;
    public $unidades_id, $codigo, $nombre, $keyword;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $unidades = Unidad::buscar($this->keyword)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsUnidades = Unidad::count();

        return view('livewire.dashboard.unidades-component')
            ->with('listarUnidades', $unidades)
            ->with('rowsUnidades', $rowsUnidades)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 12) { $rows = 12; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('limpiarUnidades')]
    public function limpiarUnidades()
    {
        $this->reset([
            'unidades_id', 'codigo', 'nombre', 'keyword'
        ]);
        $this->resetErrorBag();
    }

    public function save()
    {
        $rules = [
            'codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_dash:ascii', Rule::unique('unidades', 'codigo')->ignore($this->unidades_id)],
            'nombre'    =>  'required|min:4',
        ];
        $messages = [
            'codigo.required' => 'El codigo es obligatorio.',
            'codigo.min' => 'El codigo debe contener al menos 2 caracteres.',
            'codigo.max' => 'El codigo no debe ser mayor que 6 caracteres.',
            'codigo.alpha_num' => ' El codigo sólo debe contener letras y números.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->unidades_id)){
            //nuevo
            $unidad = new Unidad();
            $message = "Unidad Creada.";
        }else{
            //editar
            $unidad = Unidad::find($this->unidades_id);
            $message = "Unidad Actualizada.";
        }
        $unidad->codigo = $this->codigo;
        $unidad->nombre = $this->nombre;

        $unidad->save();
        $this->limpiarUnidades();
        $this->alert(
            'success',
            $message
        );


    }

    public function edit($id)
    {
        $unidad = Unidad::find($id);
        $this->unidades_id = $unidad->id;
        $this->codigo = $unidad->codigo;
        $this->nombre = $unidad->nombre;
    }

    public function destroyUnidad($id)
    {
        $this->unidades_id = $id;
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

    #[On('confirmedUnidades')]
    public function confirmedUnidades()
    {
        $unidad = Unidad::find($this->unidades_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $articulo = Articulo::where('unidades_id', $unidad->id)->first();
        if ($articulo){
            $vinculado = true;
        }

        if ($vinculado) {
            $this->alert(
                'warning',
                '¡No se puede Borrar!', [
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
        }

        $this->limpiarUnidades();
    }

    public function buscar()
    {
        //
    }

}
