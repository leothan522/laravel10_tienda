<?php

namespace App\Livewire\Dashboard;

use App\Models\AjusSegmento;
use App\Models\AjusTipo;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\Municipio;
use App\Models\Unidad;
use Livewire\Attributes\On;
use Livewire\Component;

class ReportesComponent extends Component
{

    public $empresas_id;

    public function render()
    {
        $tipos = AjusTipo::orderBy('codigo', 'asc')->get();
        /*$segmentos = AjusSegmento::orderBy('id', 'asc')->get();*/
        /*$municipios = Municipio::where('estatus', 1)->orderBy('nombre', 'ASC')->get();*/
        $articulos = Articulo::where('estatus', 1)->orderBy('codigo', 'asc')->get();
        $almacenes = Almacen::where('empresas_id', $this->empresas_id)->orderBy('codigo', 'ASC')->get();
        $unidades = Unidad::orderBy('codigo', 'ASC')->pluck('codigo', 'id');

        return view('livewire.dashboard.reportes-component')
            ->with('listarTiposAjuste', $tipos)
           /* ->with('selectSegmentos', $segmentos)*/
            /*->with('selectMunicipios', $municipios)*/
            ->with('listarArticulos', $articulos)
            ->with('listarAlmacenes', $almacenes)
            ->with('listarUnidades', $unidades)
            ;
    }

    #[On('getEmpresaReportes')]
    public function getEmpresaReportes($empresaID)
    {
        $this->empresas_id = $empresaID;
    }
}
