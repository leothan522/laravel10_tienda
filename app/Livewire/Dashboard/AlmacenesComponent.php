<?php

namespace App\Livewire\Dashboard;

use App\Models\AjusDetalle;
use App\Models\Almacen;
use App\Models\Stock;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AlmacenesComponent extends Component
{

    use LivewireAlert;

    public $rows = 0, $empresas_id;
    public $almacenes_id, $codigo, $nombre, $keyword;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $almacenes = Almacen::buscar($this->keyword)->where('empresas_id', $this->empresas_id)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get()
        ;
        $rowsAlmacenes = Almacen::count();
        return view('livewire.dashboard.almacenes-component')
            ->with('listarAlmacenes', $almacenes)
            ->with('rowsAlmacenes', $rowsAlmacenes);

    }

    public function setLimit()
    {
        if (numRowsPaginate() < 10) { $rows = 10; } else { $rows = numRowsPaginate(); }
        $this->rows = $this->rows + $rows;
    }

    #[On('getEmpresaAlmacenes')]
    public function getEmpresaAlmacenes($empresaID)
    {
        $this->empresas_id = $empresaID;
    }

    #[On('limpiarAlmacenes')]
    public function limpiarAlmacenes()
    {
        $this->reset([
            'almacenes_id', 'codigo', 'nombre', 'keyword'
        ]);
    }

    public function save()
    {
        $rules = [
            'codigo' => ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('almacenes', 'codigo')->ignore($this->almacenes_id)],
            'nombre' => 'required|min:4',
        ];
        $messages = [
            'codigo.required' => 'El campo codigo es obligatorio.',
            'codigo.min' => 'El campo codigo debe contener al menos 2 caracteres.',
            'codigo.max' => 'El campo codigo no debe ser mayor que 6 caracteres.',
            'codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->almacenes_id)) {
            //nuevo
            $almacen = new Almacen();
            $message = "Almacen Creado.";
        } else {
            //editar
            $almacen = Almacen::find($this->almacenes_id);
            $message = "Almacen Actualizado.";
        }
        $almacen->empresas_id = $this->empresas_id;
        $almacen->codigo = strtoupper($this->codigo);
        $almacen->nombre = $this->nombre;
        $almacen->save();

        $this->edit($almacen->id);

        $this->alert(
            'success',
            $message
        );

    }

    public function edit($id)
    {
        $almacen = Almacen::find($id);
        $this->almacenes_id = $almacen->id;
        $this->codigo = $almacen->codigo;
        $this->nombre = $almacen->nombre;
    }

    public function destroy($id)
    {
        $this->almacenes_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedAlmacenes',
        ]);

    }

    #[On('confirmedAlmacenes')]
    public function confirmedAlmacenes()
    {

        $almacen = Almacen::find($this->almacenes_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $detalles = AjusDetalle::where('almacenes_id', $almacen->id)->first();
        if ($detalles){
            $vinculado = true;
        }
        $stock = Stock::where('almacenes_id', $almacen->id)->first();
        if ($stock){
            $vinculado = true;
        }


        if ($vinculado) {
            $this->reset('almacenes_id');
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
            $almacen->delete();
            $this->alert(
                'success',
                'Almacen Eliminado.'
            );
            $this->limpiarAlmacenes();
        }
    }

    public function buscar()
    {
        //
    }

}
