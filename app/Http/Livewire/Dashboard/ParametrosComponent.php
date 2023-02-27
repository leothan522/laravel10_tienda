<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Parametro;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ParametrosComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['buscar', 'confirmed'];

    public $view = "create", $keyword;
    public $parametro_id, $nombre, $tabla_id, $valor;

    public function render()
    {
        $parametros = Parametro::buscar($this->keyword)->orderBy('updated_at', 'ASC')->paginate(numRowsPaginate());
        $rows = Parametro::count();
        return view('livewire.dashboard.parametros-component')
            ->with('parametros', $parametros)
            ->with('rows', $rows);
    }

    public function limpiar()
    {
        $this->reset([
            'parametro_id', 'nombre', 'tabla_id', 'valor', 'view', 'keyword'
        ]);
    }

    protected function rules($id = null)
    {
        $rules = [
            'nombre' => ['required', 'min:3', 'alpha_dash', Rule::unique('parametros', 'nombre')->ignore($id)],
            'tabla_id' => 'nullable|integer'
        ];
        return $rules;
    }

    public function save()
    {
        $type = 'success';
        $message = 'Hola Mundo';

        $this->validate($this->rules($this->parametro_id));

        if (is_null($this->parametro_id)){
            //nuevo
            $parametro = new Parametro();
            $message = "Parametro Creado";
        }else{
            //editar
            $parametro = Parametro::find($this->parametro_id);
            $message = "Parametro Actualizado";
        }

        $parametro->nombre = $this->nombre;
        if (!empty($this->tabla_id)){
            $parametro->tabla_id = $this->tabla_id;
        }
        if (!empty($this->valor)){
            $parametro->valor = $this->valor;
        }
        $parametro->save();

        $this->alert($type, $message);
        $this->limpiar();
    }

    public function edit($id)
    {
        $parametro = Parametro::find($id);
        $this->parametro_id = $parametro->id;
        $this->nombre = $parametro->nombre;
        $this->tabla_id = $parametro->tabla_id;
        $this->valor = $parametro->valor;
        $this->view = "edit";
    }

    public function buscar($keyword)
    {
        $this->keyword = $keyword;
    }

    public function destroy($id)
    {
        $this->parametro_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
        ]);
    }

    public function confirmed()
    {
        $parametro = Parametro::find($this->parametro_id);
        $parametro->delete();
        $this->limpiar();
        $this->alert(
            'success',
            'Parametro Eliminado'
        );
    }

}
