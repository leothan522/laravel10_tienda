<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\ArtIden;
use App\Models\ArtImg;
use App\Models\ArtUnid;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Precio;
use App\Models\Procedencia;
use App\Models\Stock;
use App\Models\TipoArticulo;
use App\Models\Tributario;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ArticulosComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'limpiarCategorias', 'confirmedCategorias',
        'limpiarUnidades', 'confirmedUnidades',
        'limpiarProcedencias', 'confirmedProcedencias',
        'limpiarTributarios', 'confirmedTributarios',
        'limpiarTipos', 'confirmedTipos',
        'setSelectFormArticulos', 'tipoSeleccionado', 'categoriaSeleccionada', 'procedenciaSeleccionada',
        'tributoSeleccionado', 'setSelectFormUnidades', 'unidadSeleccionada', 'secundariaSeleccionada',
        'buscar', 'confirmed', 'setSelectFormEmpresas', 'empresaSeleccionada', 'setSelectFormEditar',
        'setSelectFormEditUnd', 'setSelectPrecioEmpresas'
    ];

    public $categoria_id, $categoria_codigo, $categoria_nombre, $categoriaPhoto, $keywordCategorias;
    public $unidad_id, $unidad_codigo, $unidad_nombre, $keywordUnidades;
    public $procedencia_id, $procedencia_codigo, $procedencia_nombre, $keywordProcedencias;
    public $tributario_id, $tributario_codigo, $tributario_nombre, $keywordTributarios;
    public $tipo_id, $tipo_nombre, $keywordTipos;
    public $verMini;
    public $articulo_id, $articulo_codigo, $articulo_descripcion, $articulo_tipo, $articulo_categoria,
            $articulo_procedencia, $articulo_tributario, $articulo_unidad, $articulo_marca, $articulo_modelo,
            $articulo_referencia, $articulo_adicional, $articulo_decimales, $articulo_estatus, $articulo_fecha,
            $articulo_tipos_id, $articulo_categorias_id, $articulo_procedencias_id, $articulo_tributarios_id,
            $articulo_unidades_id, $articulo_categoria_code, $articulo_procedencia_code,
            $articulo_unidad_code;
    public $artund_unidades_id, $secundaria = false, $listarSecundarias;
    public $view, $btn_nuevo = true, $btn_cancelar = false, $footer = false, $btn_editar = false,
            $btn_und_editar = false, $btn_und_form = false, $new_articulo = false, $keyword;
    public $principalPhoto, $img_principal, $img_ver, $img_borrar_principal, $img_borrar_categoria, $img_imagen_categoria,
            $listarGaleria, $galeria_1, $geleria_2, $galeria_3, $galeria_4, $galeria_5, $galeria_6,
            $photo1, $photo2, $photo3, $photo4, $photo5, $photo6,
            $ver_galeria1, $ver_galeria2, $ver_galeria3, $ver_galeria4, $ver_galeria5, $ver_galeria6,
            $db_galeria1, $db_galeria2, $db_galeria3, $db_galeria4, $db_galeria5, $db_galeria6,
            $galeria_id1, $galeria_id2, $galeria_id3, $galeria_id4, $galeria_id5, $galeria_id6,
            $borrar_galeria1, $borrar_galeria2, $borrar_galeria3, $borrar_galeria4, $borrar_galeria5, $borrar_galeria6;
    public $listarIdentificadores, $identificador_id, $identificador_serial, $identificador_cantidad;
    public $listarPrecios, $listarPreciosUnd, $precio_id, $precio_empresas_id, $precio_unidad, $precio_moneda, $precio_precio, $precio_form = true;
    public $listarStock;

    public function mount()
    {
        $ultimo = Articulo::orderBy('codigo', 'ASC')->first();
        if ($ultimo){
            $this->view = "show";
            $this->showArticulos($ultimo->id);
        }
    }

    public function render()
    {
        if (numRowsPaginate() < 10){ $paginate = 10; }else{ $paginate = numRowsPaginate(); }

        $categorias = Categoria::buscar($this->keywordCategorias)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsCategorias = Categoria::count();
        $unidades = Unidad::buscar($this->keywordUnidades)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsUnidades = Unidad::count();
        $procedencias = Procedencia::buscar($this->keywordProcedencias)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsProcedencias = Procedencia::count();
        $tributarios = Tributario::buscar($this->keywordTributarios)->orderBy('codigo', 'ASC')->paginate($paginate);
        $rowsTributarios = Tributario::count();
        $tipos = TipoArticulo::buscar($this->keywordTipos)->paginate($paginate);
        $rowsTipos = TipoArticulo::count();
        $articulos = Articulo::buscar($this->keyword)->orderBy('codigo', 'ASC')->paginate(numRowsPaginate());
        $rowsArticulos = Articulo::count();

        return view('livewire.dashboard.articulos-component')
            ->with('listarCategorias', $categorias)
            ->with('rowsCategorias', $rowsCategorias)
            ->with('listarUnidades', $unidades)
            ->with('rowsUnidades', $rowsUnidades)
            ->with('listarProcedencias', $procedencias)
            ->with('rowsProcedencias', $rowsProcedencias)
            ->with('listarTributarios', $tributarios)
            ->with('rowsTributarios', $rowsTributarios)
            ->with('listarTipos', $tipos)
            ->with('rowsTipos', $rowsTipos)
            ->with('listarArticulos', $articulos)
            ->with('rowsArticulos', $rowsArticulos)
            ;
    }

    // ************************* Categorias ********************************************
    public function limpiarCategorias()
    {
        $this->reset([
            'categoria_id', 'categoria_codigo', 'categoria_nombre', 'categoriaPhoto', 'verMini', 'keywordCategorias',
            'img_borrar_categoria', 'img_imagen_categoria'
        ]);
    }

    public function updatedCategoriaPhoto()
    {
        $messages = [
            'categoriaPhoto.max' => 'El campo imagen no debe ser mayor que 1024 kilobytes.'
        ];
        $this->validate([
            'categoriaPhoto' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->img_imagen_categoria){
            $this->img_borrar_categoria = $this->img_imagen_categoria;
        }
    }

    public function saveCategoria()
    {
        $rules = [
            'categoria_codigo'       =>  ['required', 'min:4', 'max:8', 'alpha_num:ascii', Rule::unique('categorias', 'codigo')->ignore($this->categoria_id)],
            'categoria_nombre'    =>  'required|min:4',
            'categoriaPhoto'     =>  'image|max:1024|nullable'
        ];
        $messages = [
            'categoria_codigo.required' => 'El campo codigo es obligatorio.',
            'categoria_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'categoria_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'categoria_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'categoria_nombre.required' => 'El campo nombre es obligatorio.',
            'categoria_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.',
            'categoriaPhoto.max' => 'El campo imagen no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->categoria_id)){
            //nuevo
            $categoria = new Categoria();
            $imagen = null;
            $message = "Categoria Creada.";
        }else{
            //editar
            $categoria = Categoria::find($this->categoria_id);
            $imagen = $categoria->imagen;
            $message = "Categoria Actualizada.";
        }
        $categoria->codigo = $this->categoria_codigo;
        $categoria->nombre = $this->categoria_nombre;

        if ($this->categoriaPhoto){
            $ruta = $this->categoriaPhoto->store('public/categorias');
            $categoria->imagen = str_replace('public/', 'storage/', $ruta);
            //miniaturas
            $nombre = explode('categorias/', $categoria->imagen);
            $path_data = "storage/categorias/size_".$nombre[1];
            $miniatura = crearMiniaturas($categoria->imagen, $path_data);
            $categoria->mini = $miniatura['mini'];
            $categoria->detail = $miniatura['detail'];
            $categoria->cart = $miniatura['cart'];
            $categoria->banner = $miniatura['banner'];
            //borramos imagenes anteriones si existen
            if ($this->img_borrar_categoria){
                borrarImagenes($imagen, 'categorias');
            }
        }else{
            if ($this->img_borrar_categoria){
                $categoria->imagen = null;
                $categoria->mini = null;
                $categoria->detail = null;
                $categoria->cart = null;
                $categoria->banner = null;
                borrarImagenes($this->img_borrar_categoria, 'categorias');
            }
        }

        $categoria->save();
        $this->editCategoria($categoria->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editCategoria($id)
    {
        $this->reset('categoriaPhoto');
        $categoria = Categoria::find($id);
        $this->categoria_id = $categoria->id;
        $this->categoria_codigo = $categoria->codigo;
        $this->categoria_nombre = $categoria->nombre;
        $this->img_imagen_categoria = $categoria->imagen;
        $this->verMini = $categoria->mini;
        $this->selectFormArticulos();
    }

    public function destroyCategoria($id)
    {
        $this->categoria_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedCategorias',
        ]);
    }

    public function confirmedCategorias()
    {
        $categoria = Categoria::find($this->categoria_id);
        $imagen = $categoria->imagen;

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
            $categoria->delete();
            borrarImagenes($imagen, 'categorias');
            $this->alert(
                'success',
                'Categoria Eliminada.'
            );
            $this->limpiarCategorias();
            $this->limpiarArticulos();
        }
    }

    public function buscarCategoria()
    {
        //
    }

    public function btnBorrarImgCategoria()
    {
        $this->verMini = null;
        $this->reset('categoriaPhoto');
        $this->img_borrar_categoria = $this->img_imagen_categoria;
    }

    // ************************* Unidades ********************************************

    public function limpiarUnidades()
    {
        $this->reset([
            'unidad_id', 'unidad_codigo', 'unidad_nombre', 'keywordUnidades'
        ]);
    }

    public function saveUnidad()
    {
        $rules = [
            'unidad_codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('unidades', 'codigo')->ignore($this->unidad_id)],
            'unidad_nombre'    =>  'required|min:4',
        ];
        $messages = [
            'unidad_codigo.required' => 'El campo codigo es obligatorio.',
            'unidad_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'unidad_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'unidad_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'unidad_nombre.required' => 'El campo nombre es obligatorio.',
            'unidad_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->unidad_id)){
            //nuevo
            $unidad = new Unidad();
            $message = "Unidad Creada.";
        }else{
            //editar
            $unidad = Unidad::find($this->unidad_id);
            $message = "Unidad Actualizada.";
        }
        $unidad->codigo = $this->unidad_codigo;
        $unidad->nombre = $this->unidad_nombre;

        $unidad->save();
        $this->editUnidad($unidad->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editUnidad($id)
    {
        $unidad = Unidad::find($id);
        $this->unidad_id = $unidad->id;
        $this->unidad_codigo = $unidad->codigo;
        $this->unidad_nombre = $unidad->nombre;
    }

    public function destroyUnidad($id)
    {
        $this->unidad_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedUnidades',
        ]);
    }

    public function confirmedUnidades()
    {
        $unidad = Unidad::find($this->unidad_id);

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
            $unidad->delete();
            $this->alert(
                'success',
                'Unidad Eliminada.'
            );
            $this->limpiarUnidades();
        }
    }

    public function buscarUnidades()
    {
        //
    }

    // ************************* Procedencias ********************************************

    public function limpiarProcedencias()
    {
        $this->reset([
            'procedencia_id', 'procedencia_codigo', 'procedencia_nombre', 'keywordProcedencias'
        ]);
    }

    public function saveProcedencia()
    {
        $rules = [
            'procedencia_codigo'       =>  ['required', 'min:2', 'max:6', 'alpha_num:ascii', Rule::unique('procedencias', 'codigo')->ignore($this->procedencia_id)],
            'procedencia_nombre'    =>  'required|min:4',
        ];
        $messages = [
            'procedencia_codigo.required' => 'El campo codigo es obligatorio.',
            'procedencia_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'procedencia_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'procedencia_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'procedencia_nombre.required' => 'El campo nombre es obligatorio.',
            'procedencia_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->procedencia_id)){
            //nuevo
            $procedencia = new Procedencia();
            $message = "Procedencia Creada.";
        }else{
            //editar
            $procedencia = Procedencia::find($this->procedencia_id);
            $message = "Procedencia Actualizada.";
        }
        $procedencia->codigo = $this->procedencia_codigo;
        $procedencia->nombre = $this->procedencia_nombre;

        $procedencia->save();
        $this->editProcedencia($procedencia->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editProcedencia($id)
    {
        $procedencia = Procedencia::find($id);
        $this->procedencia_id = $procedencia->id;
        $this->procedencia_codigo = $procedencia->codigo;
        $this->procedencia_nombre = $procedencia->nombre;
        $this->selectFormArticulos();
    }

    public function destroyProcedencia($id)
    {
        $this->procedencia_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedProcedencias',
        ]);
    }

    public function confirmedProcedencias()
    {
        $procedencia = Procedencia::find($this->procedencia_id);

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
            $procedencia->delete();
            $this->alert(
                'success',
                'Procedencia Eliminada.'
            );
            $this->limpiarProcedencias();
            $this->limpiarArticulos();
        }
    }

    public function buscarProcedencias()
    {
        //
    }

    // ************************* Tributarios ********************************************

    public function limpiarTributarios()
    {
        $this->reset([
            'tributario_id', 'tributario_codigo', 'tributario_nombre', 'keywordTributarios'
        ]);
    }

    public function saveTributario()
    {
        $rules = [
            'tributario_codigo'       =>  ['required', 'min:2', 'max:8', 'alpha_num:ascii', Rule::unique('tributarios', 'codigo')->ignore($this->tributario_id)],
            'tributario_nombre'    =>  'required|numeric|between:0,100',
        ];
        $messages = [
            'tributario_codigo.required' => 'El campo codigo es obligatorio.',
            'tributario_codigo.min' => 'El campo codigo debe contener al menos 6 caracteres.',
            'tributario_codigo.max' => 'El campo codigo no debe ser mayor que 8 caracteres.',
            'tributario_codigo.alpha_num' => ' El campo codigo sólo debe contener letras y números.',
            'tributario_nombre.required' => 'El campo taza es obligatorio.',
            'tributario_nombre.numeric' => 'El campo taza debe ser numérico. ',
            'tributario_nombre.between' => 'El campo taza tiene que estar entre 0 - 100.',
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->tributario_id)){
            //nuevo
            $tributario = new Tributario();
            $message = "Taza Creada.";
        }else{
            //editar
            $tributario = Tributario::find($this->tributario_id);
            $message = "Taza Actualizada.";
        }
        $tributario->codigo = $this->tributario_codigo;
        $tributario->taza = $this->tributario_nombre;

        $tributario->save();
        $this->editTributario($tributario->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editTributario($id)
    {
        $tributario = Tributario::find($id);
        $this->tributario_id = $tributario->id;
        $this->tributario_codigo = $tributario->codigo;
        $this->tributario_nombre = $tributario->taza;
        $this->selectFormArticulos();
    }

    public function destroyTributario($id)
    {
        $this->tributario_id = $id;
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

    public function confirmedTributarios()
    {
        $tributario = Tributario::find($this->tributario_id);

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
            $tributario->delete();
            $this->alert(
                'success',
                'Taza Eliminada.'
            );
            $this->limpiarTributarios();
            $this->limpiarArticulos();
        }
    }

    public function buscarTributarios()
    {
        //
    }


    // ************************* Tipo ********************************************

    public function limpiarTipos()
    {
        $this->reset([
            'tipo_id', 'tipo_nombre', 'keywordTipos'
        ]);
    }

    public function saveTipo()
    {
        $rules = [
            'tipo_nombre'       =>  ['required', 'min:4', 'max:10', 'alpha_num:ascii', Rule::unique('articulos_tipo', 'nombre')->ignore($this->tipo_id)],
        ];
        $messages = [
            'tipo_nombre.required' => 'El campo nombre es obligatorio.',
            'tipo_nombre.min' => 'El campo nombre debe contener al menos 4 caracteres.',
            'tipo_nombre.max' => 'El campo codigo no debe ser mayor que 10 caracteres.',
            'tipo_nombre.alpha_num' => ' El campo nombre sólo debe contener letras y números.'
        ];

        $this->validate($rules, $messages);
        $message = null;
        if (is_null($this->tipo_id)){
            //nuevo
            $tipo = new TipoArticulo();
            $message = "Tipo Creado.";
        }else{
            //editar
            $tipo = TipoArticulo::find($this->tipo_id);
            $message = "Tipo Actualizado.";
        }
        $tipo->nombre = $this->tipo_nombre;

        $tipo->save();
        $this->editTipo($tipo->id);
        $this->alert(
            'success',
            $message
        );


    }

    public function editTipo($id)
    {
        $tipo = TipoArticulo::find($id);
        $this->tipo_id = $tipo->id;
        $this->tipo_nombre = $tipo->nombre;
        $this->selectFormArticulos();
    }

    public function destroyTipo($id)
    {
        $this->tipo_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedTipos',
        ]);
    }

    public function confirmedTipos()
    {
        $tipo = TipoArticulo::find($this->tipo_id);

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
            $tipo->delete();
            $this->alert(
                'success',
                'Taza Eliminada.'
            );
            $this->limpiarTipos();
            $this->limpiarArticulos();
        }
    }

    public function buscarTipos()
    {
        //
    }


    // ************************* Articulos ********************************************

    public function limpiarArticulos()
    {
        $this->resetErrorBag();
        $this->reset([
            'view', 'articulo_codigo', 'articulo_descripcion', 'articulo_tipo', 'articulo_categoria',
            'articulo_procedencia', 'articulo_tributario', 'articulo_unidad', 'articulo_marca', 'articulo_modelo',
            'articulo_referencia', 'articulo_adicional', 'articulo_decimales', 'articulo_estatus', 'articulo_fecha',
            'articulo_tipos_id', 'articulo_categorias_id', 'articulo_procedencias_id', 'articulo_tributarios_id',
            'articulo_unidades_id', 'articulo_categoria_code', 'articulo_procedencia_code',
            'articulo_unidad_code', 'btn_nuevo', 'btn_cancelar', 'footer', 'new_articulo',
            'artund_unidades_id', 'secundaria'
        ]);
    }

    public function create()
    {
        $this->limpiarArticulos();
        $this->new_articulo = true;
        $this->view = "form";
        $this->btn_nuevo = false;
        $this->btn_cancelar = true;
        $this->btn_editar = false;
        $this->footer = false;
        $this->selectFormArticulos();
    }

    public function saveArticulos()
    {
        $tipo = 'success';
        $message = null;

        $rules = [
            'articulo_codigo'           =>  ['required', 'min:4', 'max:8', 'alpha_num:ascii', Rule::unique('articulos', 'codigo')->ignore($this->articulo_id)],
            'articulo_descripcion'      =>  'required|min:4|max:40',
            'articulo_tipos_id'         => 'required',
            'articulo_categorias_id'    => 'required',
            'articulo_procedencias_id'  => 'required',
            'articulo_tributarios_id'   => 'required',
            'articulo_marca'            => 'nullable|max:40',
            'articulo_modelo'           => 'nullable|max:40',
        ];
        $messages = [
            'articulo_codigo.required'          => 'El campo nombre es obligatorio.',
            'articulo_codigo.min'               => 'El campo nombre debe contener al menos 4 caracteres.',
            'articulo_codigo.max'               => 'El campo codigo no debe ser mayor que 10 caracteres.',
            'articulo_codigo.alpha_num'         => 'El campo nombre sólo debe contener letras y números.',
            'articulo_codigo.unique'            => 'El campo codigo ya ha sido registrado. ',
            'articulo_descripcion.required'     => 'El campo descripción es obligatorio.',
            'articulo_descripcion.min'          => 'El campo descripción debe contener al menos 4 caracteres.',
            'articulo_descripcion.max'          => 'El campo descripción no debe ser mayor que 40 caracteres.',
            'articulo_tipos_id.required'        => 'El campo tipo es obligatorio.',
            'articulo_categorias_id.required'   => 'El campo categoria es obligatorio.',
            'articulo_procedencias_id.required' => 'El campo procedencia es obligatorio.',
            'articulo_tributarios_id.required'  => 'El campo I.V.A. es obligatorio.',
            'articulo_marca.max'                => 'El campo marca no debe ser mayor que 40 caracteres.',
            'articulo_modelo.max'               => 'El campo modelo no debe ser mayor que 40 caracteres.',
        ];
        $this->validate($rules, $messages);

        if ($this->articulo_id && !$this->new_articulo){
            //editar
            $articulo = Articulo::find($this->articulo_id);
            $unidad = false;
            $categ = $articulo->categorias_id;
            $message = "Articulo Actualizado.";
        }else{
            //nuevo
            $articulo = new Articulo();
            $unidad = true;
            $categ = false;
            $message = "Articulo Creado.";
        }

        $articulo->codigo = $this->articulo_codigo;
        $articulo->descripcion = $this->articulo_descripcion;
        $articulo->tipos_id = $this->articulo_tipos_id;
        $articulo->categorias_id = $this->articulo_categorias_id;
        $articulo->procedencias_id = $this->articulo_procedencias_id;
        $articulo->tributarios_id = $this->articulo_tributarios_id;
        $articulo->marca = $this->articulo_marca;
        $articulo->modelo = $this->articulo_modelo;
        $articulo->referencia = $this->articulo_referencia;
        $articulo->adicional = $this->articulo_adicional;

        $articulo->save();
        $this->reset('keyword');
        $this->showArticulos($articulo->id);
        if ($unidad){
            $this->btnUnidad();
        }

        if ($categ){
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
        $this->btn_editar = true;
        $this->view = "show";
        $this->footer = true;
        $this->articulo_id = $articulo->id;
        $this->articulo_codigo = $articulo->codigo;
        $this->articulo_descripcion = $articulo->descripcion;

        $this->articulo_tipos_id = $articulo->tipos_id;
        if ($this->articulo_tipos_id){
            $this->articulo_tipo = $articulo->tipo->nombre;
        }

        $this->articulo_categorias_id = $articulo->categorias_id;
        if ($this->articulo_categorias_id){
            $this->articulo_categoria_code = $articulo->categoria->codigo;
            $this->articulo_categoria = $articulo->categoria->nombre;
        }

        $this->articulo_procedencias_id = $articulo->procedencias_id;
        if ($this->articulo_procedencias_id){
            $this->articulo_procedencia_code = $articulo->procedencia->codigo;
            $this->articulo_procedencia = $articulo->procedencia->nombre;
        }

        $this->articulo_tributarios_id = $articulo->tributarios_id;
        if ($this->articulo_tributarios_id){
            $this->articulo_tributario = $articulo->tributario->codigo;
        }

        $this->articulo_unidades_id = $articulo->unidades_id;
        if ($this->articulo_unidades_id){
            $this->articulo_unidad_code = $articulo->unidad->codigo;
            $this->articulo_unidad = $articulo->unidad->nombre;
        }

        $this->articulo_marca = $articulo->marca;
        $this->articulo_modelo = $articulo->modelo;
        $this->articulo_referencia = $articulo->referencia;
        $this->articulo_adicional = $articulo->adicional;
        $this->articulo_decimales = $articulo->decimales;
        $this->articulo_estatus = $articulo->estatus;
        $this->articulo_fecha = $articulo->created_at;
    }

    public function destroy()
    {
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
        $articulo = Articulo::find($this->articulo_id);

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
            $articulo->delete();
            $this->alert(
                'success',
                'Articulo Eliminado.'
            );
            $this->limpiarArticulos();
            $this->btn_editar = false;
        }
    }

    // ************************* Articulos Unidades ********************************************


    public function btnUnidad()
    {
        //$this->limpiarUnidades();
        $this->view = "unidad";
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->listarSecundarias = ArtUnid::where('articulos_id', $this->articulo_id)->orderBy('id', 'ASC')->get();
        if ($this->articulo_unidad){
            $this->btn_und_editar = true;
            $this->btn_und_form = false;
            $this->secundaria = true;
        }else{
            $this->btn_und_editar = false;
            $this->btn_und_form = true;
            $this->new_articulo = true;
            $this->secundaria = false;
        }
        $this->selectFormUnidades();
    }

    public function btnEditarUnidad()
    {
        $this->secundaria = false;
        $this->btn_und_form = true;
        $this->btn_und_editar = false;
        $this->selectFormUnidades(true);
    }

    public function saveUnidades()
    {
        $type = 'success';
        $message = 'Unidad Actualizada.';

        if (!$this->secundaria){
            $rules = [
                'articulo_unidades_id'       =>  'required'
            ];
            $messages = [
                'articulo_unidades_id.required' => 'El campo unidad es obligatorio.',
            ];
            $this->validate($rules, $messages);
            $articulo = Articulo::find($this->articulo_id);
            $articulo->unidades_id = $this->articulo_unidades_id;
            $articulo->update();

            $this->articulo_unidad_code = $articulo->unidad->codigo;
            $this->articulo_unidad = $articulo->unidad->nombre;

        }else{
            $rules = [
                'artund_unidades_id'       =>  'required'
            ];
            $messages = [
                'artund_unidades_id.required' => 'El campo unidad es obligatorio.',
            ];
            $this->validate($rules, $messages);

            $existe = ArtUnid::where('articulos_id', $this->articulo_id)
                                ->where('unidades_id', $this->artund_unidades_id)->first();
            $primaria = Articulo::find($this->articulo_id);
            if (!$existe && $primaria->unidades_id != $this->artund_unidades_id){
                $artund = new ArtUnid();
                $artund->articulos_id = $this->articulo_id;
                $artund->unidades_id = $this->artund_unidades_id;
                $artund->save();
                $this->btnUnidad();
            }else{
                $type = 'warning';
                $message = 'la unidad seleccionada ya esta agregada.';
            }

        }

        if ($this->new_articulo){
            $this->showArticulos($this->articulo_id);
        }else{
            $this->btnUnidad();
        }

        $this->alert(
            $type,
            $message
        );
    }


    public function btnEliminarUnidad($id)
    {
        $artund = ArtUnid::find($id);
        $artund->delete();
        $this->btnUnidad();
        $this->alert(
            'success',
            'Unidad Eliminada.'
        );
    }




    // ************************* Imagen ********************************************

    public function btnImagen()
    {
        $this->reset([
            'principalPhoto', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6',
            'galeria_id1', 'galeria_id2', 'galeria_id3', 'galeria_id4', 'galeria_id5', 'galeria_id6',
            'borrar_galeria1', 'borrar_galeria2', 'borrar_galeria3', 'borrar_galeria4', 'borrar_galeria5', 'borrar_galeria6',
        ]);
        $articulo = Articulo::find($this->articulo_id);
        $this->img_principal = $articulo->imagen;
        $this->img_ver = $articulo->mini;
        $this->listarGaleria = ArtImg::where('articulos_id', $articulo->id)->get();
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->view = "imagen";
        $listarGaleria = ArtImg::where('articulos_id', $this->articulo_id)->get();
        $i = 0;
        foreach ($listarGaleria as $galeria){
            $i++;
            switch ($i){
                case 1:
                    $this->db_galeria1 = $galeria->imagen;
                    $this->ver_galeria1 = $galeria->mini;
                    $this->galeria_id1 = $galeria->id;
                break;
                case 2:
                    $this->db_galeria2 = $galeria->imagen;
                    $this->ver_galeria2 = $galeria->mini;
                    $this->galeria_id2 = $galeria->id;
                break;
                case 3:
                    $this->db_galeria3 = $galeria->imagen;
                    $this->ver_galeria3 = $galeria->mini;
                    $this->galeria_id3 = $galeria->id;
                break;
                case 4:
                    $this->db_galeria4 = $galeria->imagen;
                    $this->ver_galeria4 = $galeria->mini;
                    $this->galeria_id4 = $galeria->id;
                break;
                case 5:
                    $this->db_galeria5 = $galeria->imagen;
                    $this->ver_galeria5 = $galeria->mini;
                    $this->galeria_id5 = $galeria->id;
                break;
                case 6:
                    $this->db_galeria6 = $galeria->imagen;
                    $this->ver_galeria6 = $galeria->mini;
                    $this->galeria_id6 = $galeria->id;
                break;
            }
        }

    }

    public function updatedPrincipalPhoto()
    {
        $messages = [
            'principalPhoto.max' => 'la imagen no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'principalPhoto' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->img_principal){
            $this->img_borrar_principal = $this->img_principal;
        }
    }

    public function saveImagen()
    {
        $alert = false;
        $messages = [
            'principalPhoto.max' => 'la imagen no debe ser mayor que 1024 kilobytes.',
            'photo1.max' => 'la imagen 1 no debe ser mayor que 1024 kilobytes.',
            'photo2.max' => 'la imagen 2 no debe ser mayor que 1024 kilobytes.',
            'photo3.max' => 'la imagen 3 no debe ser mayor que 1024 kilobytes.',
            'photo4.max' => 'la imagen 4 no debe ser mayor que 1024 kilobytes.',
            'photo5.max' => 'la imagen 5 no debe ser mayor que 1024 kilobytes.',
            'photo6.max' => 'la imagen 6 no debe ser mayor que 1024 kilobytes.',
        ];

        $this->validate([
            'principalPhoto' => 'nullable|image|max:1024', // 1MB Max
            'photo1' => 'nullable|image|max:1024', // 1MB Max
            'photo2' => 'nullable|image|max:1024', // 1MB Max
            'photo3' => 'nullable|image|max:1024', // 1MB Max
            'photo4' => 'nullable|image|max:1024', // 1MB Max
            'photo5' => 'nullable|image|max:1024', // 1MB Max
            'photo6' => 'nullable|image|max:1024', // 1MB Max
        ], $messages);

        $articulo  = Articulo::find($this->articulo_id);

        if ($this->principalPhoto){
            //imagen actual database
            $imagen = $articulo->imagen;
            $ruta = $this->principalPhoto->store('public/articulos');
            $articulo->imagen = str_replace('public/', 'storage/', $ruta);
            //miniaturas
            $nombre = explode('articulos/', $articulo->imagen);
            $path_data = "storage/articulos/size_".$nombre[1];
            $miniatura = crearMiniaturas($articulo->imagen, $path_data);
            $articulo->mini = $miniatura['mini'];
            $articulo->detail = $miniatura['detail'];
            $articulo->cart = $miniatura['cart'];
            $articulo->banner = $miniatura['banner'];
            //borramos imagenes anteriones si existen
            if ($this->img_borrar_principal){
                borrarImagenes($imagen, 'articulos');
            }
            $alert = true;
        }else{
            if ($this->img_borrar_principal){
                $articulo->imagen = null;
                $articulo->mini = null;
                $articulo->detail = null;
                $articulo->cart = null;
                $articulo->banner = null;
                borrarImagenes($this->img_borrar_principal, 'articulos');
                $alert = true;
            }
        }

        if ($alert){
            $articulo->update();
            $this->reset('img_borrar_principal');
            $this->alert('success', 'Imagen Principal Actualizada.');
        }

        // Galeria
        for ($i = 1; $i <= 6; $i++){
            $alert_galeria = false;
            switch ($i){
                case 1:
                    $photo = $this->photo1;
                    $galeria_id = $this->galeria_id1;
                    $borrar_galeria = $this->borrar_galeria1;
                break;
                case 2:
                    $photo = $this->photo2;
                    $galeria_id = $this->galeria_id2;
                    $borrar_galeria = $this->borrar_galeria2;
                break;
                case 3:
                    $photo = $this->photo3;
                    $galeria_id = $this->galeria_id3;
                    $borrar_galeria = $this->borrar_galeria3;
                break;
                case 4:
                    $photo = $this->photo4;
                    $galeria_id = $this->galeria_id4;
                    $borrar_galeria = $this->borrar_galeria4;
                break;
                case 5:
                    $photo = $this->photo5;
                    $galeria_id = $this->galeria_id5;
                    $borrar_galeria = $this->borrar_galeria5;
                break;
                case 6:
                    $photo = $this->photo6;
                    $galeria_id = $this->galeria_id6;
                    $borrar_galeria = $this->borrar_galeria6;
                break;
            }

            if ($galeria_id){
                //editar
                $galeria = ArtImg::find($galeria_id);
                $galeria_imagen = $galeria->imagen;
            }else{
                //nuevo
                $galeria = new ArtImg();
                $galeria_imagen = null;
            }

            if ($photo){
                $ruta = $photo->store('public/galeria/art_id_'.$this->articulo_id);
                $galeria->imagen = str_replace('public/', 'storage/', $ruta);
                //miniaturas
                $nombre = explode('art_id_'.$this->articulo_id.'/', $galeria->imagen);
                $path_data = "storage/galeria/art_id_".$this->articulo_id."/size_".$nombre[1];
                $miniatura = crearMiniaturas($galeria->imagen, $path_data);
                $galeria->mini = $miniatura['mini'];
                $galeria->detail = $miniatura['detail'];
                $galeria->cart = $miniatura['cart'];
                $galeria->banner = $miniatura['banner'];
                $galeria->articulos_id = $this->articulo_id;
                $galeria->save();
                $alert_galeria = true;
                if ($borrar_galeria){
                    borrarImagenes($galeria_imagen, 'art_id_'.$this->articulo_id);
                }
            }else{
                if ($borrar_galeria){
                    $galeria->delete();
                    $alert_galeria = true;
                    borrarImagenes($galeria_imagen, 'art_id_'.$this->articulo_id);
                }
            }

            if ($alert_galeria){
                $this->alert('success', 'Galeria Actualizada.');
            }

        }
        $this->btnImagen();

    }

    public function btnBorrarImagen()
    {
        $this->img_ver = null;
        $this->reset('principalPhoto');
        $this->img_borrar_principal = $this->img_principal;
    }

    public function btnBorrarGaleria($i)
    {
        switch ($i){
            case 1:
                $this->ver_galeria1 = null;
                $this->reset('photo1');
                $this->borrar_galeria1 = $this->db_galeria1;
                break;
            case 2:
                $this->ver_galeria2 = null;
                $this->reset('photo2');
                $this->borrar_galeria2 = $this->db_galeria2;
                break;
            case 3:
                $this->ver_galeria3 = null;
                $this->reset('photo3');
                $this->borrar_galeria3 = $this->db_galeria3;
                break;
            case 4:
                $this->ver_galeria4 = null;
                $this->reset('photo4');
                $this->borrar_galeria4 = $this->db_galeria4;
                break;
            case 5:
                $this->ver_galeria5 = null;
                $this->reset('photo5');
                $this->borrar_galeria5 = $this->db_galeria5;
                break;
            case 6:
                $this->ver_galeria6 = null;
                $this->reset('photo6');
                $this->borrar_galeria6 = $this->db_galeria6;
                break;
        }
    }

    public function updatedPhoto1()
    {
        $messages = [
            'photo1.max' => 'la imagen 1 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo1' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria1){
            $this->borrar_galeria1 = $this->db_galeria1;
        }
    }

    public function updatedPhoto2()
    {
        $messages = [
            'photo2.max' => 'la imagen 2 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo2' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria2){
            $this->borrar_galeria2 = $this->db_galeria2;
        }
    }
    public function updatedPhoto3()
    {
        $messages = [
            'photo3.max' => 'la imagen 3 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo3' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria3){
            $this->borrar_galeria3 = $this->db_galeria3;
        }
    }

    public function updatedPhoto4()
    {
        $messages = [
            'photo4.max' => 'la imagen 4 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo4' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria4){
            $this->borrar_galeria4 = $this->db_galeria4;
        }
    }

    public function updatedPhoto5()
    {
        $messages = [
            'photo5.max' => 'la imagen 5 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo5' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria5){
            $this->borrar_galeria5 = $this->db_galeria5;
        }
    }

    public function updatedPhoto6()
    {
        $messages = [
            'photo6.max' => 'la imagen 6 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo6' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria6){
            $this->borrar_galeria6 = $this->db_galeria6;
        }
    }


    // ************************* Identificadores ********************************************

    public function btnIdentificadores()
    {
        $this->reset('identificador_id', 'identificador_serial', 'identificador_cantidad');
        $this->view = "identificadores";
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->listarIdentificadores = ArtIden::where('articulos_id', $this->articulo_id)->get();
    }

    public function saveIdentificadores()
    {
        $type = 'success';
        $message = null;
        $messages = [
            'identificador_serial.required' => 'El serial es obligatorio.',
            'identificador_serial.min' => 'El serial debe contener al menos 8 caracteres. ',
            'identificador_serial.unique' => 'El serial ya ha sido registrado.',
            'identificador_serial.alpha_num' => 'El serial sólo debe contener letras y números. ',
            'identificador_cantidad.required' => 'La cantidad es obligatoria',
        ];

        $this->validate([
            'identificador_serial'       =>  ['required', 'min:8', 'alpha_num:ascii', Rule::unique('articulos_identificadores', 'serial')->ignore($this->identificador_id)],
            'identificador_cantidad' => 'required',
        ], $messages);

        if ($this->identificador_id){
            //editar
            $identificador = ArtIden::find($this->identificador_id);
            $message = "Identificador Actualizado.";
        }else{
            //nuevo
            $identificador = new ArtIden();
            $message = "Identificador Creado.";
        }

        $identificador->articulos_id = $this->articulo_id;
        $identificador->serial = $this->identificador_serial;
        $identificador->cantidad = $this->identificador_cantidad;
        $identificador->save();

        $this->btnIdentificadores();

        $this->alert(
            $type,
            $message
        );
    }

    public function editarIdentificador($id)
    {
        $identificador = ArtIden::find($id);
        $this->identificador_id = $identificador->id;
        $this->identificador_serial = $identificador->serial;
        $this->identificador_cantidad = $identificador->cantidad;
    }

    public function borrarIdentificador($id)
    {
        $identificador = ArtIden::find($id);
        $identificador->delete();
        $this->btnIdentificadores();
        $this->alert('success', 'Identificador Eliminado.');
    }

    // ************************* Precios ********************************************

    public function btnPrecios()
    {
        $this->resetErrorBag();
        $this->reset('precio_id', 'precio_empresas_id', 'precio_moneda', 'precio_precio', 'precio_unidad');
        $this->view = "precios";
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->listarPrecios = Precio::where('articulos_id', $this->articulo_id)->orderBy('empresas_id', 'ASC')->get();
        $array = array();
        $articulo = Articulo::find($this->articulo_id);
        $array[] = [
            'id'        => $articulo->unidades_id,
            'codigo'    => $articulo->unidad->codigo
        ];
        $unidades = ArtUnid::where('articulos_id', $articulo->id)->get();
        foreach ($unidades as $unidad){
            $array[] = [
                'id'        => $unidad->unidades_id,
                'codigo'    => $unidad->unidad->codigo
            ];
        }
        $this->listarPreciosUnd = $array;
        $this->precio_unidad = $articulo->unidades_id;
        $this->selectFormEmpresas();
    }

    public function savePrecios()
    {
        $type = 'success';
        $message = 'hola mundo';
        $messages = [
            'precio_empresas_id.required' => 'La tienda es obligatoria.',
            'precio_moneda.required' => 'La moneda es obligatoria.',
            'precio_precio.required' => 'El precio es obligatorio.',
            'precio_unidad.required' => 'La unidad es obligatoria.',
        ];

        $this->validate([
            'precio_empresas_id' => 'required',
            'precio_moneda' => 'required',
            'precio_precio' => 'required',
            'precio_unidad' => 'required',
        ], $messages);

        if ($this->precio_id){
            //editar
            $precio = Precio::find($this->precio_id);
            $message = "Precio Actualizado.";
        }else{
            //nuevo
            $precio = new Precio();
            $message = "Precio Creado.";
        }

        $precio->articulos_id = $this->articulo_id;
        $precio->empresas_id = $this->precio_empresas_id;
        $precio->unidades_id = $this->precio_unidad;
        $precio->moneda = $this->precio_moneda;
        $precio->precio = $this->precio_precio;

        $existe = Precio::where('articulos_id', $this->articulo_id)
                            ->where('empresas_id', $this->precio_empresas_id)
                            ->where('unidades_id', $this->precio_unidad)
                            ->where('id', '!=', $this->precio_id)
                            ->first();

        if ($existe){
            $type = 'warning';
            $message = 'El precio para esa UND ya existe.';
        }else{
            $precio->save();
            $this->btnPrecios();
        }

        $this->alert(
            $type,
            $message
        );

    }


    public function editarPrecio($id)
    {
        $precio = Precio::find($id);
        $this->precio_id = $precio->id;
        $this->precio_empresas_id = $precio->empresas_id;
        $this->precio_moneda = $precio->moneda;
        $this->precio_precio = $precio->precio;
        $this->precio_unidad = $precio->unidades_id;
        $this->precio_form = true;
        $this->emit('setSelectPrecioEmpresas', $this->precio_empresas_id);
    }

    public function borrarPrecio($id)
    {
        $precio = Precio::find($id);
        $precio->delete();
        $this->btnPrecios();
        $this->alert('success', 'Precio Eliminado.');
    }




    // ************************* Existencias ********************************************

    public function btnExistencias()
    {
        $this->reset(['listarStock']);
        $this->view = "existencias";
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->listarStock = Stock::where('articulos_id', $this->articulo_id)->orderBy('empresas_id', 'ASC')->get();
    }



    // ************************* Extras ********************************************

    public function selectFormArticulos($editar = false)
    {
        $categorias = dataSelect2(Categoria::orderBy('nombre', 'ASC')->get());
        $tipos = dataSelect2(TipoArticulo::get());
        $procedencias = dataSelect2(Procedencia::get());
        $tributarios = dataSelect2(Tributario::get());
        $this->emit('setSelectFormArticulos', $tipos, $categorias, $procedencias, $tributarios);
        if ($editar){
            $this->emit('setSelectFormEditar', $this->articulo_tipos_id, $this->articulo_categorias_id, $this->articulo_procedencias_id, $this->articulo_tributarios_id);
        }
    }

    public function selectFormUnidades($editar = false)
    {
        $unidades = dataSelect2(Unidad::get());
        $this->emit('setSelectFormUnidades', $unidades);
        if ($editar){
            $articulo = Articulo::find($this->articulo_id);
            $this->emit('setSelectFormEditUnd', $articulo->unidades_id);
        }
    }

    public function selectFormEmpresas()
    {
        $empresas = Empresa::get();
        $array = array();
        foreach ($empresas as $empresa){
            $acceso = comprobarAccesoEmpresa($empresa->permisos, Auth::id());
            $precio = Precio::where('empresas_id', $empresa->id)->where('articulos_id', $this->articulo_id)->first();
            if ($acceso /*&& !$precio*/){
                array_push($array, $empresa);
            }
        }

        $empresas = dataSelect2($array);
        $this->precio_form = $empresas;
        $this->emit('setSelectFormEmpresas', $empresas);
    }

    public function btnCancelar()
    {
        if ($this->articulo_id){
            $this->showArticulos($this->articulo_id);
        }else{
            $this->limpiarArticulos();
        }
    }

    public function btnEditar()
    {
        $this->view = 'form';
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->footer = false;
        $this->selectFormArticulos(true);
    }

    public function btnActivoInactivo()
    {
        $articulo = Articulo::find($this->articulo_id);
        if ($this->articulo_estatus){
            $articulo->estatus = 0;
            $this->articulo_estatus = 0;
            $message = "Articulo Inactivo";
        }else{
            $articulo->estatus = 1;
            $this->articulo_estatus = 1;
            $message = "Articulo Activo";
        }
        $articulo->update();
        $this->alert(
            'success',
            $message
        );
    }

    public function setSelectFormArticulos($tipos, $categorias, $procedencias, $tributarios)
    {
        //select categorias formulario articulos
    }

    public function setSelectFormEditar($tipos, $categorias, $procedencias, $tributarios)
    {
        //select categorias formulario articulos
    }

    public function setSelectFormUnidades($unidades)
    {
        //select categorias formulario articulos
    }

    public function setSelectFormEditUnd($unidades)
    {
        //select categorias formulario articulos
    }

    public function setSelectFormEmpresas($empresas)
    {
        //select empresas formulario precios
    }

    public function setSelectPrecioEmpresas($empresas)
    {
        //select empresas formulario precios
    }

    public function tipoSeleccionado($id)
    {
        $this->articulo_tipos_id = $id;
    }

    public function categoriaSeleccionada($id)
    {
        $this->articulo_categorias_id = $id;
    }

    public function procedenciaSeleccionada($id)
    {
        $this->articulo_procedencias_id = $id;
    }

    public function tributoSeleccionado($id)
    {
        $this->articulo_tributarios_id = $id;
    }

    public function unidadSeleccionada($id)
    {
        $this->articulo_unidades_id = $id;
    }

    public function secundariaSeleccionada($id)
    {
        $this->artund_unidades_id = $id;
    }

    public function empresaSeleccionada($id)
    {
        $this->precio_empresas_id = $id;
    }

    public function buscar($keyword)
    {
        $this->keyword = $keyword;
    }

    public function cerrarBusqueda()
    {
        $this->reset('keyword');
        $this->limpiarArticulos();
    }




}
