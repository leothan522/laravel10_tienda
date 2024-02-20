<?php

namespace App\Livewire\Dashboard;

use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Stock;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticulosExistenciasComponent extends Component
{
    use LivewireAlert;

    public $articulos_id, $empresas_id, $principal_code;

    public function render()
    {
        $stock = Stock::where('empresas_id', $this->empresas_id)
            ->where('articulos_id', $this->articulos_id)
            ->get();
        $almacenes = Almacen::where('empresas_id', $this->empresas_id)->get();
        return view('livewire.dashboard.articulos-existencias-component')
            ->with('listarStock', $stock)
            ->with('listarAlmacenes', $almacenes);
    }

    #[On('getArticuloExistencias')]
    public function getArticuloExistencias($articuloID)
    {
        $this->articulos_id = $articuloID;
        $articulo = Articulo::find($this->articulos_id);
        $this->empresas_id = $articulo->empresas_id;
        if ($articulo->unidades_id){
            $this->principal_code = $articulo->unidad->codigo;
        }
    }

}
