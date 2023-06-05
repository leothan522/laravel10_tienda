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

function comprobarAccesoEmpresa($permisos, $user_id)
{
    if (leerJson($permisos, $user_id) || Auth::user()->roler == 1 || Auth::user()->role == 100){
        return true;
    }else{
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
        'Tiendas' => [
            'route' => 'empresas.index',
            'submenu' => [
                'Crear Tiendas' => 'empresas.create',
                '[Abrir][Cerrar] Tiendas' => 'empresas.estatus',
                'Definir Horarios' => 'empresas.horario',
                'Editar Tiendas' => 'empresas.edit',
                'Borrar Tiendas' => 'empresas.destroy'

            ]
        ],
        'Stock' => [
            'route' => 'stock.index',
            /*'submenu' => [
                'Crear Articulos' => 'articulos.create',
                'Editar Articulos' => 'articulos.edit',
                'Borrar Articulos' => 'articulos.destroy'

            ]*/
        ],
        'Articulos' => [
            'route' => 'articulos.index',
            'submenu' => [
                'Crear Articulos' => 'articulos.create',
                'Editar Articulos' => 'articulos.edit',
                'Borrar Articulos' => 'articulos.destroy'

            ]
        ],
        'Categorias' => [
            'route' => 'categorias.index',
            'submenu' => [
                'Crear categorias' => 'categorias.create',
                'Editar categorias' => 'categorias.edit',
                'Borrar categorias' => 'categorias.destroy'

            ]
        ],
        'Unidades' => [
            'route' => 'unidades.index',
            'submenu' => [
                'Crear unidades' => 'unidades.create',
                'Editar unidades' => 'unidades.edit',
                'Borrar unidades' => 'unidades.destroy'

            ]
        ],
        /*'Procedencias' => [
            'route' => 'procedencias.index',
            'submenu' => [
                'Crear procedencias' => 'procedencias.create',
                'Editar procedencias' => 'procedencias.edit',
                'Borrar procedencias' => 'procedencias.destroy'

            ]
        ],
        'Tributarios' => [
            'route' => 'tributarios.index',
            'submenu' => [
                'Crear tributarios' => 'tributarios.create',
                'Editar tributarios' => 'tributarios.edit',
                'Borrar tributarios' => 'tributarios.destroy'

            ]
        ]*/
    ];
    return $permisos;
}
