//efecto sweetalert 2
function verCargando()
{
    Cargando.fire();
}

function cerrarCargando()
{
    Cargando.close();
}

//Cerrar Sesion
function cerrarSesion() {
    $('#btn_cerrar_sesion').click();
}

//cambiar topbar al iniciar sesion con el modal
function setTopBar(nombre) {
    $('#topbar_nombre_usuario').text(nombre);
    $('#topbar_datos_usuario').removeClass('d-none');
    $('#topbar_botones_derecha').addClass('d-none');
}
