<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Parametro;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DolarComponent extends Component
{
    use LivewireAlert;

    public $dollar = 1, $edit = false, $parametro_id;

    public function render()
    {
        $parametros = Parametro::where('nombre', 'precio_dolar')->first();
        if ($parametros){
            $this->dollar = number_format($parametros->valor, 2);
            $this->parametro_id = $parametros->id;
        }
        return view('livewire.dashboard.dolar-component');
    }

    public function edit($valor)
    {
        if ($valor){
            $this->reset(['edit', 'dollar', 'parametro_id']);
        }else{
            $this->edit = true;
        }
    }

    public function save()
    {
        $tipo = 'success';
        $message = null;

        if (is_numeric($this->dollar)){

            if ($this->parametro_id){
                $parametro = Parametro::find($this->parametro_id);
            }else{
                $parametro = new Parametro();
                $parametro->nombre = 'precio_dolar';
            }
            $parametro->valor = round($this->dollar, 2);
            $parametro->tabla_id = Auth::id();
            $parametro->save();
            $message = 'Precio Actualizado.';
            $this->reset(['edit', 'dollar', 'parametro_id']);

        }else{
            $tipo = 'error';
            $message = "El precio debe ser numerico.";
        }

        $this->alert(
            $tipo,
            $message
        );
    }



}
