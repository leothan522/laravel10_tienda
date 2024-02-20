<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Precio;
use App\Models\Stock;
use App\Models\Unidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticulosPreciosComponent extends Component
{
    use LivewireAlert;

    public $articulos_id, $empresas_id, $precios_id;
    public $unidades_id, $moneda, $precio;

    public function render()
    {
        $unidades = Unidad::orderBy('codigo', 'ASC')->get();
        $unidades->each(function ($unidad) {
            $unidad->ver = true;
            $exite = Precio::where('articulos_id', $this->articulos_id)
                ->where('unidades_id', $unidad->id)
                ->where('empresas_id', $this->empresas_id)
                ->first();
            if ($exite && $exite->id != $this->precios_id) {
                $unidad->ver = false;
            }
        });

        $precios = Precio::where('articulos_id', $this->articulos_id)
            ->where('empresas_id', $this->empresas_id)
            ->get();
        return view('livewire.dashboard.articulos-precios-component')
            ->with('listarUnidades', $unidades)
            ->with('listarPrecios', $precios)
            ;
    }

    #[On('getArticuloPrecios')]
    public function getArticuloPrecios($articuloID)
    {
        $this->articulos_id = $articuloID;
        $this->limpiarPrecios();
        $articulo = Articulo::find($this->articulos_id);
        $this->empresas_id = $articulo->empresas_id;
    }

    public function limpiarPrecios()
    {
        $this->reset([
            'unidades_id', 'moneda', 'precio', 'precios_id'
        ]);
    }

    public function rules()
    {
        return [
            'empresas_id' => 'required',
            'moneda' => 'required',
            'precio' => 'required|numeric|gte:0',
            'unidades_id' => 'required',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->precios_id){
            $precio = Precio::find($this->precios_id);
        }else{
            $precio = new Precio();
        }
        $precio->articulos_id = $this->articulos_id;
        $precio->empresas_id = $this->empresas_id;
        $precio->unidades_id = $this->unidades_id;
        $precio->moneda = $this->moneda;
        $precio->precio = $this->precio;
        $precio->save();
        $this->limpiarPrecios();
        $this->alert('success', 'Precio Establecido.');
    }

    public function edit($id)
    {
        $precio = Precio::find($id);
        $this->precios_id = $precio->id;
        $this->unidades_id = $precio->unidades_id;
        $this->moneda = $precio->moneda;
        $this->precio = $precio->precio;
        $this->dispatch('setUnidad', id: $this->unidades_id);
    }

    public function destroy($id)
    {
        $precio = Precio::find($id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $articulo_id = $precio->articulos_id;
        $unidad_id = $precio->unidades_id;
        $empresa_id = $precio->empresas_id;
        $stock = Stock::where('articulos_id', $articulo_id)
            ->where('unidades_id', $unidad_id)
            ->where('empresas_id', $empresa_id)
            ->first();
        if ($stock){
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
            $precio->delete();
            $this->limpiarPrecios();
            $this->alert('success', 'Precio Eliminado.');
        }
    }

    #[On('setUnidad')]
    public function setUnidad($id)
    {
        //JS
    }
}
