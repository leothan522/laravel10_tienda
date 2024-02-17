<?php

namespace App\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\AjusTipo;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class TiposAjustesComponent extends Component
{
    use LivewireAlert;

    public $tipos_id, $codigo, $nombre, $tipo = 1, $keyword, $rows = 0;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $tiposAjuste = AjusTipo::buscar($this->keyword)->orderBy('codigo', 'ASC')->limit($this->rows)->get();
        $rows = AjusTipo::count();
        return view('livewire.dashboard.tipos-ajustes-component')
            ->with('listarTiposAjuste', $tiposAjuste)
            ->with('rowsTipos', $rows);
    }

    #[On('limpiarTiposAjuste')]
    public function limpiarTiposAjuste()
    {
        $this->reset([
            'tipos_id', 'codigo', 'nombre', 'tipo', 'keyword'
        ]);
    }

    public function save()
    {
        $rules = [
            'codigo' => ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('ajustes_tipos', 'codigo')->ignore($this->tipos_id)],
            'nombre' => 'required|min:4',
        ];
        $messages = [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.min' => 'El código debe contener al menos 2 caracteres.',
            'codigo.max' => 'El código no debe ser mayor que 6 caracteres.',
            'codigo.alpha_num' => ' El campo código sólo debe contener letras y números.',
            'nombre.required' => 'La descripción es obligatoria.',
            'nombre.min' => 'La descripción debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->tipos_id)) {
            //nuevo
            $tipo = new AjusTipo();
            $message = "Tipo de Ajuste Creado.";
        } else {
            //editar
            $tipo = AjusTipo::find($this->tipos_id);
            $message = "Tipo de Ajuste Actualizado.";
        }
        $tipo->codigo = $this->codigo;
        $tipo->descripcion = $this->nombre;
        $tipo->tipo = $this->tipo;
        $tipo->save();

        $this->edit($tipo->id);

        $this->alert(
            'success',
            $message
        );

    }

    public function edit($id)
    {
        $tipo = AjusTipo::find($id);
        $this->tipos_id = $tipo->id;
        $this->codigo = $tipo->codigo;
        $this->nombre = $tipo->descripcion;
        $this->tipo = $tipo->tipo;
    }

    public function destroy($id)
    {
        $this->tipos_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedTiposAjuste',
        ]);

    }

    #[On('confirmedTiposAjuste')]
    public function confirmedTiposAjuste()
    {

        $tipo = AjusTipo::find($this->tipos_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $detalles = AjusDetalle::where('tipos_id', $tipo->id)->first();
        if ($detalles){
            $vinculado = true;
        }

        if ($vinculado) {
            $this->reset('tipos_id');
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

    public function buscar()
    {
        //
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 10) { $rows = 10; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

}
