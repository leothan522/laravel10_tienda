<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Parametro;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UsuariosComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['buscar', 'confirmedUser', 'verPermisos',
        'saveRol', 'addRolList', 'setRolList', 'confirmedRol', 'removeRolList'];

    public $view = "create", $keyword;
    public $name, $email, $password, $role, $usuario_id;
    public $edit_name, $edit_email, $edit_password, $edit_role = 0, $edit_roles_id = 0, $created_at, $estatus = 1, $photo, $empresas_id;
    public $tabla = "usuarios", $tabla_id, $tabla_nombre, $tabla_email, $tabla_permisos;

    public function render()
    {
        $roles = Parametro::where('tabla_id', '-1')->get();
        $users = User::buscar($this->keyword)
            ->orderBy('role', 'DESC')
            ->orderBy('roles_id', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->paginate(numRowsPaginate());
        $rows = User::count();
        return view('livewire.dashboard.usuarios-component')
            ->with('roles', $roles)
            ->with('users', $users)
            ->with('rows', $rows);
    }

    public function limpiar()
    {
        $this->reset([
            'view', 'keyword', 'name', 'email', 'password', 'role', 'usuario_id',
            'edit_name', 'edit_email', 'edit_password', 'edit_role', 'edit_roles_id', 'created_at', 'estatus', 'photo', 'empresas_id',
            'tabla', 'tabla_id', 'tabla_nombre', 'tabla_permisos', 'tabla_email'
        ]);
    }

    public function generarClave()
    {
        $this->password = Str::password(8);
    }

    protected function rules($id = null)
    {
        if ($id) {
            $rules = [
                'edit_name' => 'required|min:4',
                'edit_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            ];
        } else {
            $rules = [
                'name' => 'required|min:4',
                'email' => ['required', 'email', Rule::unique('users')],
                'password' => 'required|min:8',
                'role' => 'required'
            ];
        }
        return $rules;
    }

    protected $messages = [

        'edit_name.required' => 'El campo nombre es obligatorio.',
        'edit_name.min' => 'El campo nombre debe contener al menos 4 caracteres.',
        'edit_email.required' => 'El campo correo electrónico es obligatorio.',
        'edit_email.email' => 'El campo correo electrónico no es un correo válido.',

    ];

    public function save()
    {
        $type = 'success';
        $message = 'Hola Mundo';
        $this->validate($this->rules($this->usuario_id));

        if (is_null($this->usuario_id)) {
            //nuevo
            $usuarios = new User();
            $usuarios->name = ucwords($this->name);
            $usuarios->email = strtolower($this->email);
            $usuarios->password = Hash::make($this->password);
            if ($this->role > 1) {
                $usuarios->role = 2;
                $usuarios->roles_id = $this->role;
                $role = Parametro::where('tabla_id', '-1')->where('id', $this->role)->first();
                if ($role) {
                    $usuarios->permisos = $role->valor;
                }
            } else {
                $usuarios->role = $this->role;
                $usuarios->roles_id = null;
            }
            $message = "Usuario Creado";
            $usuarios->save();
            $this->alert($type, $message);
            $this->limpiar();
        } else {
            //editar
            $usuarios = User::find($this->usuario_id);
            $usuarios->name = ucwords($this->edit_name);
            $usuarios->email = strtolower($this->edit_email);
            if ($this->edit_role > 1) {
                $usuarios->role = 2;
                $usuarios->roles_id = $this->edit_role;
                $role = Parametro::where('tabla_id', '-1')->where('id', $this->edit_role)->first();
                if ($role) {
                    $usuarios->permisos = $role->valor;
                }
            } else {
                $usuarios->role = $this->edit_role;
                $usuarios->roles_id = null;
            }
            $message = "Usuario Actualizado";
            $usuarios->update();
            $this->alert($type, $message);
            $this->edit($this->usuario_id);

        }
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        $this->usuario_id = $usuario->id;
        $this->edit_name = $usuario->name;
        $this->edit_email = $usuario->email;
        if ($usuario->roles_id) {
            $this->edit_role = $usuario->roles_id;
        }else{
            $this->edit_role = $usuario->role;
        }
        //$this->edit_role = $usuario->role;
        $this->edit_roles_id = $usuario->roles_id;
        $this->estatus = $usuario->estatus;
        $this->created_at = $usuario->created_at;
        $this->photo = $usuario->profile_photo_path;
        $this->empresas_id = $usuario->empresas_id;
    }

    public function cambiarEstatus($id)
    {
        $usuario = User::find($id);
        if ($usuario->estatus) {
            $usuario->estatus = 0;
            $texto = "Usuario Suspendido";
        } else {
            $usuario->estatus = 1;
            $texto = "Usuario Activado";
        }
        $usuario->update();
        $this->estatus = $usuario->estatus;
        $this->alert(
            'success',
            $texto
        );
    }

    public function restablecerClave($id)
    {
        if (!$this->edit_password) {
            $clave = Str::password(8);
        } else {
            $clave = $this->edit_password;
        }
        $usuario = User::find($id);
        $usuario->password = Hash::make($clave);
        $usuario->update();
        $this->edit_password = $clave;
        $this->alert(
            'success',
            'Contraseña Restablecida'
        );
    }

    public function destroyUser($id)
    {
        $this->usuario_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedUser',
        ]);
    }

    public function confirmedUser()
    {
        $usuario = User::find($this->usuario_id);

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
            $usuario->delete();
            $this->alert(
                'success',
                'Usuario Eliminado.'
            );
            $this->limpiar();
        }

    }

    public function buscar($keyword)
    {
        $this->keyword = $keyword;
    }

    public function verPermisos($tabla, $id)
    {
        $this->tabla = $tabla;
        if ($this->tabla == "usuarios") {
            $usuarios = User::find($id);
            $this->tabla_id = $usuarios->id;
            $this->tabla_nombre = $usuarios->name;
            $this->tabla_email = $usuarios->email;
            $this->tabla_permisos = $usuarios->permisos;
        } else {
            $parametro = Parametro::find($id);
            $this->tabla_id = $parametro->id;
            $this->tabla_nombre = $parametro->nombre;
            $this->tabla_email = null;
            $this->tabla_permisos = $parametro->valor;
        }

    }

    public function saveRol($nombre)
    {
        $type = "success";
        $message = "Parametro Creado.";

        if ((empty($nombre) || strlen($nombre) <= 3)) {
            $type = "warning";
            $message = "el campo nombre es requerido min 4 caracteres.";
        } else {

            $parametro = Parametro::where('nombre', $nombre)->where('tabla_id', -1)->first();
            if ($parametro) {
                //exite
                $type = "error";
                $message = "el rol ${nombre} ya existe.";
            } else {
                //crear
                $parametro = new Parametro();
                $parametro->nombre = $nombre;
                $parametro->tabla_id = -1;
                $parametro->save();
                $this->emit('addRolList', $parametro->id, ucwords($parametro->nombre));
            }

        }

        $this->alert(
            $type,
            $message
        );
    }

    public function updateRol()
    {
        $type = "success";
        $message = "Parametro Actualizado.";

        if ((empty($this->tabla_nombre) || strlen($this->tabla_nombre) <= 3)) {
            $type = "warning";
            $message = "el campo nombre es requerido min 4 caracteres.";
        } else {

            $parametro = Parametro::where('nombre', $this->tabla_nombre)->where('tabla_id', -1)->where('id', '!=', $this->tabla_id)->first();
            if ($parametro) {
                //exite
                $type = "error";
                $message = "el rol " . $this->tabla_nombre . " ya existe.";
            } else {
                //crear
                $parametro = Parametro::find($this->tabla_id);
                $parametro->nombre = $this->tabla_nombre;
                $parametro->update();
                $this->emit('setRolList', $parametro->id, ucwords($parametro->nombre));
            }

            $this->alert(
                $type,
                $message
            );
        }
    }

    public function destroyRol($id)
    {
        $this->tabla_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => '¡Sí, bórralo!',
            'text' => '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedRol',
        ]);
    }

    public function confirmedRol()
    {
        // Example code inside confirmed callback
        $usuarios = User::where('roles_id', $this->tabla_id)->first();
        if ($usuarios) {

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

            $parametro = Parametro::find($this->tabla_id);
            $id = $parametro->id;
            $parametro->delete();
            $this->emit('removeRolList', $id);

            $this->alert(
                'success',
                'Parametro Eliminado.'
            );
            $this->limpiar();

        }
    }

    public function updatePermisos($id, $permiso)
    {
        $type = "success";
        $message = "Exito";
        $permisos = [];

        if ($this->tabla == "parametros"){
            //roles
            $tabla = Parametro::find($id);
            $tabla_permisos = $tabla->valor;
        }else{
            //usuarios
            $tabla = User::find($id);
            $tabla_permisos = $tabla->permisos;
        }

        if (!leerJson($tabla_permisos, $permiso)){
            $permisos = json_decode($tabla_permisos, true);
            $permisos[$permiso] = true;
            $permisos = json_encode($permisos);
            $message = "Permiso Agregado.";
        }else{
            $permisos = json_decode($tabla_permisos, true);
            unset($permisos[$permiso]);
            $permisos = json_encode($permisos);
            $message = "Permiso Eliminado.";
        }

        if ($this->tabla == "parametros"){
            $tabla->valor = $permisos;
        }else{
            $tabla->permisos = $permisos;
        }

        $tabla->update();
        $this->tabla_permisos = $permisos;
        $this->alert(
            $type,
            $message
        );
    }

    public function updateRolUsuarios()
    {
        $usuarios = User::where('roles_id', $this->tabla_id)->get();
        foreach ($usuarios as $user){
            $usuario = User::find($user->id);
            $usuario->permisos = $this->tabla_permisos;
            $usuario->update();
        }
        $this->alert(
            'success',
            'Usuarios Actualizados.'
        );
    }

    public function addRolList()
    {
        //agrego rol nuevo al right-sidebar
    }

    public function setRolList()
    {
        //edito nombre a un rol rol nuevo en el right-sidebar
    }

    public function removeRolList()
    {
        //elimino a un rol del right-sidebar
    }

}
