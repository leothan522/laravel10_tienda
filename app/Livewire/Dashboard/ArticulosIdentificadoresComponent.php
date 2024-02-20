<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\ArtIden;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticulosIdentificadoresComponent extends Component
{
    use LivewireAlert;

    public $articulos_id, $identificadores_id;
    public $serial, $cantidad;

    public function render()
    {
        $identificadores = ArtIden::get();
        return view('livewire.dashboard.articulos-identificadores-component')
            ->with('listarIdentificadores', $identificadores);
    }

    #[On('getArticuloIdentificadores')]
    public function getArticuloIdentificadores($articuloID)
    {
        $this->articulos_id = $articuloID;
        $this->limpiarIdentificadores();
    }

    public function limpiarIdentificadores()
    {
        $this->resetErrorBag();
        $this->reset([
            'serial', 'cantidad', 'identificadores_id'
        ]);
    }

    public function rules()
    {
        return [
            'serial' => ['required', 'min:8', 'alpha_num:ascii', Rule::unique('articulos_identificadores', 'serial')->ignore($this->identificadores_id)],
            'cantidad' => 'required|numeric|gte:0',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->identificadores_id){
            $identificador = ArtIden::find($this->identificadores_id);
        }else{
            $identificador = new ArtIden();
        }
        $identificador->articulos_id = $this->articulos_id;
        $identificador->serial = $this->serial;
        $identificador->cantidad = $this->cantidad;
        $identificador->save();
        $this->limpiarIdentificadores();
        $this->alert('success', 'Datos Guardados.');
    }

    public function edit($id)
    {
        $identificador = ArtIden::find($id);
        $this->identificadores_id = $identificador->id;
        $this->serial = $identificador->serial;
        $this->cantidad = $identificador->cantidad;
    }

    public function destroy($id)
    {
        $identificador = ArtIden::find($id);

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
            $identificador->delete();
            $this->limpiarIdentificadores();
            $this->alert('success', 'Identificador Eliminado.');
        }
    }



}
