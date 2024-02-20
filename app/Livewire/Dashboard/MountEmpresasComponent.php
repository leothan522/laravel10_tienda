<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MountEmpresasComponent extends Component
{

    public $empresaID, $empresa, $listarEmpresas, $rows;

    public function mount()
    {
        $this->getEmpresaDefault();
    }

    public function render()
    {
        if ($this->empresaID){
            $this->empresa = Empresa::find($this->empresaID);
        }

        $this->getEmpresas();
        return view('livewire.dashboard.mount-empresas-component');
    }

    public function getEmpresaDefault()
    {
        if (auth()->user()->role == 100) {
            $empresa = Empresa::where('default', 1)->first();
            if ($empresa) {
                $this->empresaID = $empresa->id;
            }
        } else {
            $empresas = Empresa::orderBy('default', 'DESC')->get();
            foreach ($empresas as $empresa) {
                $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
                if ($acceso) {
                    $this->empresaID = $empresa->id;
                    break;
                }
            }
        }
    }

    public function getEmpresas()
    {
        $empresas = Empresa::get();
        if ($empresas->isNotEmpty()){
            $array = array();
            foreach ($empresas as $empresa) {
                $acceso = comprobarAccesoEmpresa($empresa->permisos, auth()->id());
                if ($acceso) {
                    array_push($array, $empresa);
                }
            }
            $this->listarEmpresas = dataSelect2($array);
        }
        $this->rows = $empresas->count();
    }

    #[On('updatedEmpresaID')]
    public function updatedEmpresaID()
    {
        $this->dispatch('getEmpresaAjuste', empresaID: $this->empresaID)->to(AjustesComponent::class);
        $this->dispatch('getEmpresaAlmacenes', empresaID: $this->empresaID)->to(AlmacenesComponent::class);
        $this->dispatch('getEmpresaReportes', empresaID: $this->empresaID)->to(ReportesComponent::class);
        $this->dispatch('getEmpresaStock', empresaID: $this->empresaID)->to(StockComponent::class);
        $this->dispatch('getEmpresaArticulos', empresaID: $this->empresaID)->to(ArticulosComponent::class);
    }


}
