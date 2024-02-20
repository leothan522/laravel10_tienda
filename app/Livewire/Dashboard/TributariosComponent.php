<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Tributario;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class TributariosComponent extends Component
{
    use LivewireAlert;

    public $rows = 0;
    public $tributarios_id, $codigo, $tributario_nombre, $keyword;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $tributarios = Tributario::buscar($this->keyword)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsTributarios = Tributario::count();

        return view('livewire.dashboard.tributarios-component')
            ->with('listarTributarios', $tributarios)
            ->with('rowsTributarios', $rowsTributarios)
            ;
    }

    public function setLimit()
    {
        if (numRowsPaginate() < 12) { $rows = 12; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('limpiarTributarios')]
    public function limpiarTributarios()
    {
        $this->reset([
            'tributarios_id', 'codigo', 'tributario_nombre', 'keyword'
        ]);
        $this->resetErrorBag();
    }

    public function save()
    {
        $rules = [
            'codigo'       =>  ['required', 'min:2', 'max:8', 'alpha_num:ascii', Rule::unique('tributarios', 'codigo')->ignore($this->tributarios_id)],
            'tributario_nombre'    =>  'required|numeric|between:0,100',
        ];
        $messages = [
            'codigo.required' => 'El codigo es obligatorio.',
            'codigo.min' => 'El codigo debe contener al menos 6 caracteres.',
            'codigo.max' => 'El codigo no debe ser mayor que 8 caracteres.',
            'codigo.alpha_num' => ' El codigo sólo debe contener letras y números.',
            'tributario_nombre.required' => 'La taza es obligatorio.',
            'tributario_nombre.numeric' => 'La taza debe ser numérico. ',
            'tributario_nombre.between' => 'La taza tiene que estar entre 0 - 100.',
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->tributarios_id)){
            //nuevo
            $tributario = new Tributario();
            $message = "Taza Creada.";
        }else{
            //editar
            $tributario = Tributario::find($this->tributarios_id);
            $message = "Taza Actualizada.";
        }
        $tributario->codigo = $this->codigo;
        $tributario->taza = $this->tributario_nombre;

        $tributario->save();
        $this->dispatch('listarSelect', tabla: 'tributarios')->to(ArticulosComponent::class);
        $this->limpiarTributarios();
        $this->alert(
            'success',
            $message
        );


    }

    public function edit($id)
    {
        $tributario = Tributario::find($id);
        $this->tributarios_id = $tributario->id;
        $this->codigo = $tributario->codigo;
        $this->tributario_nombre = $tributario->taza;
        //$this->selectFormArticulos();
    }

    public function destroy($id)
    {
        $this->tributarios_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedTributarios',
        ]);
    }

    #[On('confirmedTributarios')]
    public function confirmedTributarios()
    {
        $tributario = Tributario::find($this->tributarios_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $articulo = Articulo::where('tributarios_id', $tributario->id)->first();
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
            $tributario->delete();
            $this->alert(
                'success',
                'Taza Eliminada.'
            );

            $this->dispatch('listarSelect', tabla: 'tributarios')->to(ArticulosComponent::class);
        }

        $this->limpiarTributarios();
    }

    public function buscar()
    {
        //
    }

}
