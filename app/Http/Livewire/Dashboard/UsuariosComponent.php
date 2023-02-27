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
    protected $listeners = ['buscar', 'confirmedUser'];

    public $view = "create", $keyword;
    public $name, $email, $password, $role, $usuario_id;
    public $edit_name, $edit_email, $edit_password, $edit_role = 0, $edit_roles_id = 0, $created_at, $estatus = 1, $photo, $empresas_id;

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
            'edit_name', 'edit_email', 'edit_role', 'edit_roles_id', 'created_at', 'estatus', 'photo', 'empresas_id'
        ]);
    }

    public function generarClave()
    {
        $this->password = Str::password(8);
    }

    protected function rules($id = null)
    {
        if ($id){
            $rules = [
                'edit_name'      =>  'required|min:4',
                'edit_email'     =>  ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            ];
        }else{
            $rules = [
                'name'      =>  'required|min:4',
                'email'     =>  ['required', 'email', Rule::unique('users')],
                'password'  =>  'required|min:8',
                'role'      =>  'required'
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

        if (is_null($this->usuario_id)){
            //nuevo
            $usuarios = new User();
            $usuarios->name = $this->name;
            $usuarios->email = strtolower($this->email);
            $usuarios->password = Hash::make($this->password);
            if ($this->role > 1){
                $usuarios->role = 2;
                $usuarios->roles_id = $this->role;
                $role = Parametro::where('tabla_id', '-1')->where('id', $this->role)->first();
                if ($role){
                    $usuarios->permisos = $role->valor;
                }
            }else{
                $usuarios->role = $this->role;
                $usuarios->roles_id = null;
            }
            $message = "Usuario Creado";
            $usuarios->save();
            $this->alert($type, $message);
            $this->limpiar();
        }else{
            //editar
            $usuarios = User::find($this->usuario_id);
            $usuarios->name = $this->edit_name;
            $usuarios->email = strtolower($this->edit_email);
            if ($this->edit_role > 1){
                $usuarios->role = 2;
                $usuarios->roles_id = $this->edit_role;
                $role = Parametro::where('tabla_id', '-1')->where('id', $this->edit_role)->first();
                if ($role){
                    $usuarios->permisos = $role->valor;
                }
            }else{
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
        /*if ($usuario->roles_id) {
            $this->edit_role = $usuario->roles_id;
        }else{
            $this->edit_role = $usuario->role;
        }*/
        $this->edit_role = $usuario->role;
        $this->edit_roles_id = $usuario->roles_id;
        $this->estatus = $usuario->estatus;
        $this->created_at = $usuario->created_at;
        $this->photo = $usuario->profile_photo_path;
        $this->empresas_id = $usuario->empresas_id;
    }

    public function cambiarEstatus($id)
    {
        $usuario = User::find($id);
        if ($usuario->estatus){
            $usuario->estatus = 0;
            $texto = "Usuario Suspendido";
        }else{
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
        if (!$this->edit_password){
            $clave = Str::password(8);
        }else{
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
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedUser',
        ]);
    }

    public function confirmedUser()
    {
        $usuario = User::find($this->usuario_id);

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;

        if ($vinculado){
            $this->alert('warning', '¡No se puede Borrar!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'El registro que intenta borrar ya se encuentra vinculado con otros procesos.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);
        }else{
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

}
