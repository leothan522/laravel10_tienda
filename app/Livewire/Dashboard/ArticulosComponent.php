<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Procedencia;
use App\Models\Stock;
use App\Models\TipoArticulo;
use App\Models\Tributario;
use App\Models\Unidad;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticulosComponent extends Component
{
    use LivewireAlert;

    public $rows = 0, $numero = 14, $empresas_id, $tableStyle = false;
    public $view, $nuevo = true, $cancelar = false, $footer = false, $edit = false, $new_articulo = false, $keyword;
    public $articulos_id, $codigo, $descripcion, $tipos_id, $categorias_id, $procedencias_id, $tributarios_id,
        $marca, $modelo, $referencia, $adicional, $decimales, $estatus;
    public $tipo, $categoria, $categorias_code, $procedencia, $procedencias_code, $tributario, $fecha,
        $unidad, $unidades_code;
    public $imagen = false, $existencias = false;

    public function mount()
    {
        $this->setLimit();
    }

    public function render()
    {
        $articulos = Articulo::buscar($this->keyword)
            ->where('empresas_id', $this->empresas_id)
            ->orderBy('codigo', 'ASC')
            ->limit($this->rows)
            ->get();
        $rowsArticulos = Articulo::count();
        $listarCategorias = Categoria::orderBy('codigo', 'ASC')->get();
        $listarUnidades = Unidad::orderBy('codigo', 'ASC')->get();
        $listarProcedencia = Procedencia::orderBy('codigo', 'ASC')->get();
        $listarTributatio = Tributario::orderBy('codigo', 'ASC')->get();
        $listarTipo = TipoArticulo::get();

        if ($rowsArticulos > $this->numero) {
            $this->tableStyle = true;
        }

        return view('livewire.dashboard.articulos-component')
            ->with('listarArticulos', $articulos)
            ->with('rowsArticulos', $rowsArticulos)
            ->with('selectCategorias', $listarCategorias)
            ->with('selectUnidades', $listarUnidades)
            ->with('selectProcedencia', $listarProcedencia)
            ->with('selectTributario', $listarTributatio)
            ->with('selectTipo', $listarTipo);
    }

    public function setLimit()
    {
        if (numRowsPaginate() < $this->numero) {
            $rows = $this->numero;
        } else {
            $rows = numRowsPaginate();
        }
        $this->rows = $this->rows + $rows;
    }

    #[On('getEmpresaArticulos')]
    public function getEmpresaArticulos($empresaID)
    {
        $this->empresas_id = $empresaID;
        $this->limpiarArticulos();
        $ultimo = Articulo::orderBy('codigo', 'ASC')->where('empresas_id', $this->empresas_id)->first();
        if ($ultimo) {
            $this->view = "show";
            $this->showArticulos($ultimo->id);
        }
    }

    public function limpiarArticulos()
    {
        $this->resetErrorBag();
        $this->reset([
            'view', 'codigo', 'descripcion', 'tipo', 'categoria',
            'procedencia', 'tributario', 'unidad', 'marca', 'modelo',
            'referencia', 'adicional', 'decimales', 'estatus', 'fecha',
            'tipos_id', 'categorias_id', 'procedencias_id', 'tributarios_id',
            'categorias_code', 'procedencias_code',
            'unidades_code', 'nuevo', 'cancelar', 'footer', 'new_articulo', 'imagen', 'existencias'
        ]);
    }

    public function create()
    {
        $this->limpiarArticulos();
        $this->new_articulo = true;
        $this->view = "form";
        $this->nuevo = false;
        $this->cancelar = true;
        $this->edit = false;
        $this->footer = false;
        //$this->selectFormArticulos();
        $this->listarSelect('tipos');
        $this->listarSelect('categorias');
        $this->listarSelect('procedencias');
        $this->listarSelect('tributarios');
    }

    public function save()
    {
        $tipo = 'success';
        $message = null;
        if ($this->articulos_id && !$this->new_articulo){
            $codigo = ['required', 'min:4', 'max:8', 'alpha_num:ascii', Rule::unique('articulos', 'codigo')->ignore($this->articulos_id)];
        }else{
            $codigo = ['required', 'min:4', 'max:8', 'alpha_num:ascii', Rule::unique('articulos', 'codigo')];
        }
        $rules = [
            'codigo' => $codigo,
            'descripcion' => 'required|min:4|max:40',
            'tipos_id' => 'required',
            'categorias_id' => 'required',
            'procedencias_id' => 'required',
            'tributarios_id' => 'required',
            'marca' => 'nullable|max:40',
            'modelo' => 'nullable|max:40',
        ];
        $messages = [
            'codigo.required' => 'El codigo es obligatorio.',
            'codigo.min' => 'El codigo debe contener al menos 4 caracteres.',
            'codigo.max' => 'El codigo no debe ser mayor que 10 caracteres.',
            'codigo.alpha_num' => 'El codigo sólo debe contener letras y números.',
            'codigo.unique' => 'El codigo ya ha sido registrado. ',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe contener al menos 4 caracteres.',
            'descripcion.max' => 'La descripción no debe ser mayor que 40 caracteres.',
            'tipos_id.required' => 'El tipo es obligatorio.',
            'categorias_id.required' => 'La categoria es obligatoria.',
            'procedencias_id.required' => 'La procedencia es obligatoria.',
            'tributarios_id.required' => 'El I.V.A. es obligatorio.',
            'marca.max' => 'La marca no debe ser mayor que 40 caracteres.',
            'modelo.max' => 'El modelo no debe ser mayor que 40 caracteres.',
        ];
        $this->validate($rules, $messages);

        if ($this->articulos_id && !$this->new_articulo) {
            //editar
            $articulo = Articulo::find($this->articulos_id);
            $unidad = false;
            $categ = $articulo->categorias_id;
            $message = "Articulo Actualizado.";
        } else {
            //nuevo
            $articulo = new Articulo();
            $unidad = true;
            $categ = false;
            $message = "Articulo Creado.";
        }

        $articulo->codigo = $this->codigo;
        $articulo->descripcion = $this->descripcion;
        $articulo->tipos_id = $this->tipos_id;
        $articulo->categorias_id = $this->categorias_id;
        $articulo->procedencias_id = $this->procedencias_id;
        $articulo->tributarios_id = $this->tributarios_id;
        $articulo->marca = $this->marca;
        $articulo->modelo = $this->modelo;
        $articulo->referencia = $this->referencia;
        $articulo->adicional = $this->adicional;
        $articulo->empresas_id = $this->empresas_id;

        $articulo->save();
        $this->reset('keyword');
        $this->showArticulos($articulo->id);
        if ($unidad) {
            $this->dispatch('clickBtnUnidad');
        }

        if ($categ) {
            $categoria = Categoria::find($categ);
            $categoria->cantidad = $categoria->cantidad - 1;
            $categoria->update();
        }

        $categoria = Categoria::find($articulo->categorias_id);
        $categoria->cantidad = $categoria->cantidad + 1;
        $categoria->update();

        $this->alert(
            $tipo,
            $message
        );
    }

    public function showArticulos($id)
    {
        $this->limpiarArticulos();
        $articulo = Articulo::find($id);
        $this->edit = true;
        $this->view = "show";
        $this->footer = true;
        $this->articulos_id = $articulo->id;
        $this->codigo = $articulo->codigo;
        $this->descripcion = $articulo->descripcion;

        $this->tipos_id = $articulo->tipos_id;
        if ($this->tipos_id) {
            $this->tipo = $articulo->tipo->nombre;
        }

        $this->categorias_id = $articulo->categorias_id;
        if ($this->categorias_id) {
            $this->categorias_code = $articulo->categoria->codigo;
            $this->categoria = $articulo->categoria->nombre;
        }

        $this->procedencias_id = $articulo->procedencias_id;
        if ($this->procedencias_id) {
            $this->procedencias_code = $articulo->procedencia->codigo;
            $this->procedencia = $articulo->procedencia->nombre;
        }

        $this->tributarios_id = $articulo->tributarios_id;
        if ($this->tributarios_id) {
            $this->tributario = $articulo->tributario->codigo;
        }

        if ($articulo->unidades_id) {
            $this->unidades_code = $articulo->unidad->codigo;
            $this->unidad = $articulo->unidad->nombre;
        }

        $this->marca = $articulo->marca;
        $this->modelo = $articulo->modelo;
        $this->referencia = $articulo->referencia;
        $this->adicional = $articulo->adicional;
        $this->decimales = $articulo->decimales;
        $this->estatus = $articulo->estatus;
        $this->fecha = $articulo->created_at;
    }

    public function destroy()
    {
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
        ]);
    }

    #[On('confirmed')]
    public function confirmed()
    {
        $articulo = Articulo::find($this->articulos_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $stock = Stock::where('articulos_id', $articulo->id)->first();
        if ($stock) {
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
            $articulo->delete();
            $this->alert(
                'success',
                'Articulo Eliminado.'
            );
            $this->edit = false;
            $this->limpiarArticulos();
        }
    }
    #[On('buscar')]
    public function buscar($keyword)
    {
        $this->keyword = $keyword;
    }

    public function cerrarBusqueda()
    {
        $this->reset('keyword');
        $this->limpiarArticulos();
    }

    public function btnCancelar()
    {
        if ($this->articulos_id) {
            $this->showArticulos($this->articulos_id);
        } else {
            $this->limpiarArticulos();
        }
    }

    public function btnEditar()
    {
        $this->view = 'form';
        $this->edit = false;
        $this->cancelar = true;
        $this->footer = false;
        $this->imagen = false;
        $this->existencias = false;
        //$this->selectFormArticulos(true);
        $this->listarSelect('tipos');
        $this->listarSelect('categorias');
        $this->listarSelect('procedencias');
        $this->listarSelect('tributarios');
    }

    public function btnActivoInactivo()
    {
        $this->imagen = false;
        $this->existencias = false;
        $articulo = Articulo::find($this->articulos_id);
        if ($this->estatus){
            $articulo->estatus = 0;
            $this->estatus = 0;
            $message = "Articulo Inactivo";
        }else{
            $articulo->estatus = 1;
            $this->estatus = 1;
            $message = "Articulo Activo";
        }
        $articulo->update();
        $this->alert(
            'success',
            $message
        );
    }

    #[On('listarSelect')]
    public function listarSelect($tabla)
    {
        switch ($tabla) {
            case 'tipos';
                $model = TipoArticulo::get();
                $idSelect = 'select_articulos_tipos';
                $icono = 'fas fa-object-ungroup';
                $evento = 'setTipos';
                $id = $this->tipos_id;
                break;
            case 'categorias';
                $model = Categoria::get();
                $idSelect = 'select_articulos_categorias';
                $icono = 'fas fa-tags';
                $evento = 'setCategorias';
                $id = $this->categorias_id;
                break;
            case 'procedencias';
                $model = Procedencia::get();
                $idSelect = 'select_articulos_procedencias';
                $icono = 'fas fa-object-ungroup';
                $evento = 'setProcedencias';
                $id = $this->procedencias_id;
                break;
            case 'tributarios';
                $model = Tributario::get();
                $idSelect = 'select_articulos_tributarios';
                $icono = 'fas fa-coins';
                $evento = 'setTributario';
                $id = $this->tributarios_id;
                break;
        }

        $data = dataSelect2($model);
        $this->dispatch('selectFormArticulos', id: $idSelect, data: $data, evento: $evento, icono: $icono);
        if ($id) {
            $this->dispatch('setSelectFormArticulos', id: $idSelect, valor: $id);
        }
    }

    #[On('setTipos')]
    public function setTipos($id)
    {
        $this->tipos_id = $id;
    }

    #[On('setCategorias')]
    public function setCategorias($id)
    {
        $this->categorias_id = $id;
    }

    #[On('setProcedencias')]
    public function setProcedencias($id)
    {
        $this->procedencias_id = $id;
    }

    #[On('setTributario')]
    public function setTributario($id)
    {
        $this->tributarios_id = $id;
    }

    #[On('selectFormArticulos')]
    public function selectFormArticulos($id, $data, $evento, $icono = 'far fa-bookmark')
    {
        //JS
    }

    #[On('setSelectFormArticulos')]
    public function setSelectFormArticulos($id, $valor)
    {
        //JS
    }

    public function btnImagen()
    {
        $this->dispatch('getArticuloImagenes', articuloID: $this->articulos_id)->to(ArticulosImagenesComponent::class);
        $this->imagen = true;
        $this->existencias = false;
        $this->cancelar = true;
    }

    public function btnUnidad()
    {
        $this->dispatch('getArticuloUnidades', articuloID: $this->articulos_id)->to(ArticulosUnidadesComponent::class);
    }

    #[On('clickBtnUnidad')]
    public function clickBtnUnidad()
    {
        //JS
    }

    public function btnPrecios()
    {
        $this->dispatch('getArticuloPrecios', articuloID: $this->articulos_id)->to(ArticulosPreciosComponent::class);
    }

    public function btnIdentificadores()
    {
        $this->dispatch('getArticuloIdentificadores', articuloID: $this->articulos_id)->to(ArticulosIdentificadoresComponent::class);
    }

    public function btnExistencias()
    {
        $this->dispatch('getArticuloExistencias', articuloID: $this->articulos_id)->to(ArticulosExistenciasComponent::class);
        $this->existencias = true;
        $this->imagen = false;
        $this->cancelar = true;
    }



}
