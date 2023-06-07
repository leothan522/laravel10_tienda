<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Almacen;
use App\Models\Empresa;
use App\Models\Parametro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmpresasComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    protected $listeners = ['buscar', 'confirmed'];

    public $view = "show", $keyword, $title = "Datos de la Tienda", $btn_cancelar = false, $footer = true;
    public $empresa_id, $empresa_default, $verDefault, $verImagen, $img_borrar_principal, $img_principal;
    public $rif, $nombre, $jefe, $moneda, $telefonos, $email, $direccion, $photo, $default = 0, $permisos;
    public $horario, $horario_id, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $apertura, $cierre;


    public function mount()
    {
        $empresas = Empresa::where('default', 1)->first();
        if ($empresas){
            $this->empresa_default = $empresas->id;
            $this->show($this->empresa_default);
        }else{
            $this->create();
            $this->default = 1;
            $this->btn_cancelar = false;
        }
    }

    public function render()
    {
        $tiendas = Empresa::buscar($this->keyword)->orderBy('created_at', 'ASC')->get();
        return view('livewire.dashboard.empresas-component')
            ->with('tiendas', $tiendas);
    }

    public function limpiar()
    {
        $this->reset([
            'view', 'title', 'btn_cancelar', 'footer', 'empresa_id', 'verDefault', 'verImagen', 'keyword',
            'rif', 'nombre', 'jefe', 'moneda', 'telefonos', 'email', 'direccion', 'photo', 'permisos', 'img_borrar_principal'
        ]);
    }

    public function create()
    {
        $this->limpiar();
        $this->title = "Nueva Tienda";
        $this->btn_cancelar = true;
        $this->view = "form";
        $this->footer = false;

    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
        if ($this->img_principal){
            $this->img_borrar_principal = $this->img_principal;
        }
    }

    public function rules()
    {
        return [
            'rif'       =>  ['required', 'min:6', Rule::unique('empresas')->ignore($this->empresa_id)],
            'nombre'    =>  'required|min:4',
            'jefe'      =>  'required|min:4',
            'moneda'    =>  'required',
            'telefonos' =>  'required',
            'email'     =>  'required|email',
            'direccion' =>  'required',
            'photo'     =>  'image|max:1024|nullable'
        ];
    }

    public function save()
    {
        $tipo = 'success';
        $message = null;
        $almacen = false;

        $this->validate();

        if ($this->empresa_id){
            //editar
            $empresa = Empresa::find($this->empresa_id);
            $imagen = $empresa->imagen;
            $message = "Datos Guardados.";
        }else{
            //nuevo
            $empresa = new Empresa();
            $imagen = null;
            $message = "Empresa Creada.";
            $empresa->default = $this->default;
            if ($this->default){
                $this->default = 0;
            }
            $permisos[Auth::id()] = true;
            $permisos = json_encode($permisos);
            $empresa->permisos = $permisos;
            $almacen = true;
        }

        $empresa->rif = strtoupper($this->rif);
        $empresa->nombre = strtoupper($this->nombre);
        $empresa->supervisor = strtoupper($this->jefe);
        $empresa->moneda = $this->moneda;
        $empresa->telefono = $this->telefonos;
        $empresa->email = strtolower($this->email);
        $empresa->direccion = strtoupper($this->direccion);



        if ($this->photo){
            $ruta = $this->photo->store('public/empresas');
            $empresa->imagen = str_replace('public/', 'storage/', $ruta);
            //miniaturas
            $nombre = explode('empresas/', $empresa->imagen);
            $path_data = "storage/empresas/size_".$nombre[1];
            $miniatura = crearMiniaturas($empresa->imagen, $path_data);
            $empresa->mini = $miniatura['mini'];
            $empresa->detail = $miniatura['detail'];
            $empresa->cart = $miniatura['cart'];
            $empresa->banner = $miniatura['banner'];
            //borramos imagenes anteriones si existen
            if ($this->img_borrar_principal){
                borrarImagenes($imagen, 'empresas');
            }
        }else{
            if ($this->img_borrar_principal){
                $empresa->imagen = null;
                $empresa->mini = null;
                $empresa->detail = null;
                $empresa->cart = null;
                $empresa->banner = null;
                borrarImagenes($this->img_borrar_principal, 'empresas');
            }
        }

        $empresa->save();

        if ($almacen){
            $almacen = new Almacen();
            $almacen->empresas_id = $empresa->id;
            $almacen->codigo = "ALMP";
            $almacen->nombre = "Almacen Principal";
            $almacen->tipo = 1;
            $almacen->save();
        }

        $this->show($empresa->id);

        $this->alert(
            $tipo,
            $message
        );

    }

    public function show($id)
    {
        $this->limpiar();
        $this->empresa_id = $id;
        $empresa = Empresa::find($this->empresa_id);
        $this->nombre = $empresa->nombre;
        $this->rif = $empresa->rif;
        $this->jefe = $empresa->supervisor;
        $this->moneda = $empresa->moneda;
        $this->telefonos = $empresa->telefono;
        $this->email = $empresa->email;
        $this->direccion = $empresa->direccion;
        $this->permisos = $empresa->permisos;
        $this->verDefault = $empresa->default;
        $this->verImagen = $empresa->mini;
        $this->img_principal = $empresa->imagen;
        $this->view = "show";
    }

    public function edit()
    {
        $this->title = "Editar Tienda";
        $this->btn_cancelar = true;
        $this->view = "form";
    }

    public function convertirDefault($id)
    {
        $buscar = Empresa::where('default', 1)->first();
        if ($buscar){
            $buscar->default = 0;
            $buscar->update();
        }

        $empresa = Empresa::find($id);
        $empresa->default = 1;
        $empresa->update();

        $this->empresa_default = $empresa->id;
        $this->verDefault = $empresa->default;

        $this->alert(
            'success',
            'Datos Guardados.'
        );
    }

    public function destroy($id)
    {
        $this->empresa_id = $id;
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
        $empresa = Empresa::find($this->empresa_id);
        $imagen = $empresa->imagen;

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
            $empresa->delete();
            borrarImagenes($imagen, 'empresas');
            $this->alert(
                'success',
                'Tienda Eliminada.'
            );
            $this->show($this->empresa_default);
        }
    }

    public function dias($dia, $id = false)
    {
        $parametro = Parametro::where('nombre', "horario_$dia")->where('tabla_id', $this->empresa_id)->first();
        if ($parametro){
            if ($id){
                return $parametro->id;
            }else{
                return $parametro->valor;
            }
        }else{
            return 0;
        }
    }

    public function verHorario()
    {

        $horario = Parametro::where('nombre', 'horario')->where('tabla_id', $this->empresa_id)->first();
        if ($horario){
            $this->horario_id = $horario->id;
            $this->horario = $horario->valor;
        }else{
            $this->horario_id = 0;
            $this->horario = 0;
        }

        $this->lunes = $this->dias('Mon');
        $this->martes = $this->dias('Tue');
        $this->miercoles = $this->dias('Wed');
        $this->jueves = $this->dias('Thu');
        $this->viernes = $this->dias('Fri');
        $this->sabado = $this->dias('Sat');
        $this->domingo = $this->dias('Sun');

        $apertura = Parametro::where('nombre', 'horario_apertura')->where('tabla_id', $this->empresa_id)->first();
        if ($apertura){
            $this->apertura = $apertura->valor;
        }else{
            $this->apertura = null;
        }

        $cierre = Parametro::where('nombre', 'horario_cierre')->where('tabla_id', $this->empresa_id)->first();
        if ($cierre){
            $this->cierre = $cierre->valor;
        }else{
            $this->cierre = null;
        }

        $this->title = "Datos de la Tienda";
        $this->btn_cancelar = true;
        $this->view = "horario";
    }

    public function botonHorario($id)
    {
        $tipo = 'success';
        $message = null;
        if ($id){
            $parametro = Parametro::find($id);
            if ($parametro->valor == 1){
                $parametro->valor = 0;
                $tipo = 'info';
                $message = 'Horario Apagado.';
            }else{
                $parametro->valor = 1;
                $tipo = 'success';
                $message = 'Horario Activo.';
            }
            $parametro->update();
        }else{
            $parametro = new Parametro();
            $parametro->nombre = "horario";
            $parametro->tabla_id = $this->empresa_id;
            $parametro->valor = 1;
            $parametro->save();
            $this->horario_id = $parametro->id;
            $tipo = "success";
            $message = 'Horario Activo.';
        }

        $this->alert(
            $tipo,
            $message
        );

        $this->horario = $parametro->valor;

    }

    public function diasActivos($dia, $valor)
    {
        $tipo = 'success';
        $message = null;
        $id = $this->dias($dia, true);
        if ($id){

            $parametro = Parametro::find($id);
            if ($valor == 0){
                $parametro->valor = 1;
                $tipo = "success";
                $message = 'Dia Abierto.';
            }else{
                $parametro->valor = 0;
                $tipo = "info";
                $message = 'Dia Cerrado.';
            }
            $parametro->update();

        }else{

            $parametro = new Parametro();
            $parametro->nombre = "horario_$dia";
            $parametro->tabla_id = $this->empresa_id;
            $parametro->valor = 1;
            $parametro->save();
            $tipo = "success";
            $message = 'Dia Abierto.';

        }

        $this->lunes = $this->dias('Mon');
        $this->martes = $this->dias('Tue');
        $this->miercoles = $this->dias('Wed');
        $this->jueves = $this->dias('Thu');
        $this->viernes = $this->dias('Fri');
        $this->sabado = $this->dias('Sat');
        $this->domingo = $this->dias('Sun');

        $this->alert(
            $tipo,
            $message
        );
    }

    public function storeHoras()
    {
        $rules = [
            'apertura'  =>  'required',
            'cierre'    => 'required_with:apertura|after:apertura'
        ];
        $message = [
            'cierre.after'  =>  'cierre debe ser posterior a apertura. '
        ];

        $this->validate($rules, $message);

        $apertura = Parametro::where('nombre', 'horario_apertura')->where('tabla_id', $this->empresa_id)->first();
        if ($apertura){
            $apertura->valor = $this->apertura;
            $apertura->update();
        }else{
            $parametro = new Parametro();
            $parametro->nombre = "horario_apertura";
            $parametro->tabla_id = $this->empresa_id;
            $parametro->valor = $this->apertura;
            $parametro->save();
        }

        $cierre = Parametro::where('nombre', 'horario_cierre')->where('tabla_id', $this->empresa_id)->first();
        if ($cierre){
            $cierre->valor = $this->cierre;
            $cierre->update();
        }else{
            $parametro = new Parametro();
            $parametro->nombre = "horario_cierre";
            $parametro->tabla_id = $this->empresa_id;
            $parametro->valor = $this->cierre;
            $parametro->save();
        }

        $this->alert(
            'success',
            'Horas Guardadas.'
        );

    }

    public function estatusTienda($id)
    {

        $tipo = 'success';
        $message = null;

        $estatus_tienda = Parametro::where('nombre', 'estatus_tienda')->where('tabla_id', $id)->first();
        if ($estatus_tienda){
            $parametro = Parametro::find($estatus_tienda->id);
            if ($parametro->valor == 1){
                $parametro->valor = 0;
                $tipo = 'info';
                $message = 'Tienda Cerrada.';
            }else{
                $parametro->valor = 1;
                $tipo = 'success';
                $message = 'Tienda Abierta.';
            }
            $parametro->update();
        }else{
            $parametro = new Parametro();
            $parametro->nombre = "estatus_tienda";
            $parametro->tabla_id = $id;
            $parametro->valor = 1;
            $parametro->save();
            $tipo = 'success';
            $message = 'Tienda Abierta.';
        }

        $this->alert(
            $tipo,
            $message
        );

    }

    public function buscar($keyword)
    {
        $this->keyword = $keyword;
    }

    public function btnBorrarImagen()
    {
        $this->verImagen = null;
        $this->reset('photo');
        $this->img_borrar_principal = $this->img_principal;
    }



}
