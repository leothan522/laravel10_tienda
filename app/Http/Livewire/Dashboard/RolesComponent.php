<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Parametro;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RolesComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'save', 'addRolList', 'edit', 'setRolList', 'confirmedRol', 'removeRolList',
    ];

    public $roles_id, $nombre, $tabla = 'roles', $getPermisos, $cambios = false;

    public function render()
    {
        return view('livewire.dashboard.roles-component');
    }

    public function limpiarRoles()
    {
        $this->reset([
            'roles_id', 'nombre', 'getPermisos', 'cambios'
        ]);
    }

    public function save($nombre = null)
    {
        if (!is_null($nombre)){

            $nombre = mb_strtolower($nombre);

            $count = Parametro::where('tabla_id', -1)->count();
            if ($count >= 10){
                $this->alert(
                    'warning',
                    'El maximo de roles permitidos es 10'
                );
                return [];
            }

        }else{
            $nombre = mb_strtolower($this->nombre);
        }

        if (empty($nombre) || strlen($nombre) <= 3) {
            $this->alert(
                'warning',
                'el campo nombre es requerido min 4 caracteres.'
            );
            return [];
        }

        if (strlen($nombre) >= 15) {
            $this->alert(
                'warning',
                'el campo nombre solo puede tener 15 caracteres.'
            );
            return [];
        }

        $existe = Parametro::where('nombre', $nombre)->where('tabla_id', -1)->first();
        if ($existe || $nombre == 'administrador' || $nombre == 'estandar'){
            $this->alert(
                'error',
                'El rol <b class="text-danger">'.ucfirst($nombre).'</b> ya existe.'
            );
            return [];
        }

        if ($this->roles_id){
            //editar
            $parametro = Parametro::find($this->roles_id);
        }else{
            //nuevo
            $parametro = new Parametro();
        }

        $parametro->nombre = $nombre;
        $parametro->tabla_id = -1;
        $parametro->save();

        if ($this->roles_id){
            $this->emit('setRolList', $parametro->id, ucwords($parametro->nombre));
            $this->edit($parametro->id);
            $this->alert(
                'success',
                'Rol Actualizado.'
            );
        }else{
            $this->emit('addRolList', $parametro->id, ucwords($parametro->nombre), $count + 1);
            $this->limpiarRoles();
            $this->alert(
                'success',
                'Rol Creado.'
            );
        }

        $this->emit('limpiar');

    }

    public function edit($id)
    {
        $rol = Parametro::find($id);
        $this->roles_id = $rol->id;
        $this->nombre = $rol->nombre;
        $this->getPermisos = $rol->valor;
        $this->reset('cambios');
    }

    public function destroy($id)
    {
        $this->roles_id = $id;
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
        $row = Parametro::find($this->roles_id);
        $id = $row->id;

        //codigo para verificar si realmente se puede borrar, dejar false si no se requiere validacion
        $vinculado = false;
        $usuarios = User::where('roles_id', $id)->first();
        if ($usuarios){
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
            $row->delete();
            $this->limpiarRoles();
            $this->emit('removeRolList', $id);
            $this->alert(
                'success',
                'Rol Eliminado.'
            );

        }
    }

    public function addRolList($id, $nombre, $rows)
    {
        //agrego rol nuevo al right-sidebar
    }

    public function setRolList($id, $nombre)
    {
        //edito nombre a un rol rol nuevo en el right-sidebar
    }

    public function removeRolList($id)
    {
        //elimino a un rol del right-sidebar
    }

    public function setPermisos($permiso)
    {
        $permisos = [];
        if (!leerJson($this->getPermisos, $permiso)){
            $permisos = json_decode($this->getPermisos, true);
            $permisos[$permiso] = true;
            $permisos = json_encode($permisos);
            $message = "Permiso Agregado.";
        }else{
            $permisos = json_decode($this->getPermisos, true);
            unset($permisos[$permiso]);
            $permisos = json_encode($permisos);
            $message = "Permiso Eliminado.";
        }
        $this->getPermisos = $permisos;
        $this->cambios = true;
    }

    public function savePermisos(){
        $rol = Parametro::find($this->roles_id);
        $rol->valor = $this->getPermisos;
        $rol->save();
        $usuarios = User::where('roles_id', $rol->id)->get();
        foreach ($usuarios as $user){
            $usuario = User::find($user->id);
            $usuario->permisos = $this->getPermisos;
            $usuario->save();
        }
        $this->reset('cambios');
        $this->alert('success', 'Permisos Guardados.');
    }

    public function deletePermisos()
    {
        $this->reset('getPermisos');
        $this->cambios = true;
    }

}
