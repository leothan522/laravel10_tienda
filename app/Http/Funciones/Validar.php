<?php
//Funciones Personalizadas para el Proyecto
use Illuminate\Support\Facades\Auth;

function comprobarPermisos($routeName = null)
{

    if (leerJson(Auth::user()->permisos, $routeName) || Auth::user()->role == 1 || Auth::user()->role == 100) {
        return true;
    } else {
        return false;
    }

}

function allPermisos()
{
    $permisos = [
        'Usuarios' => [
            'route' => 'usuarios.index',
            'submenu' => [
                'Crear Usuarios' => 'usuarios.create',
                'Editar Usuarios' => 'usuarios.edit',
                'Suspender Usuarios' => 'usuarios.estatus',
                'Reestablecer Contraseña' => 'usuarios.password',
                'Descargar Excel' => 'usuarios.excel',
                'Eliminar Usuarios' => 'usuarios.destroy',
            ]
        ],
    ];
    return $permisos;
}
