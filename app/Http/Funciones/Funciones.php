<?php
//Funciones Personalizadas para el Proyecto

use App\Models\Parametro;
//use App\Models\Producto;
//use App\Models\Stock;
use Carbon\Carbon;
//use Intervention\Image\Facades\Image;

function hola(){
    return "Funciones Personalidas bien creada";
}

//Leer JSON
function leerJson($json, $key)
{
    if ($json == null) {
        return null;
    } else {
        $json = $json;
        $json = json_decode($json, true);
        if (array_key_exists($key, $json)) {
            return $json[$key];
        } else {
            return null;
        }
    }
}

//Alertas de sweetAlert2
function verSweetAlert2($mensaje, $alert = null, $type = 'success', $icono = '<i class="fa fa-trash-alt"></i>', $title = '¡Éxito!')
{
    switch ($alert){
        default:
            alert()->success('¡Éxito!',$mensaje)->persistent(true,false);
            break;
        case "iconHtml":
            alert($title, $mensaje, $type)->iconHtml($icono)->persistent(true,false)->toHtml();
            break;
        case "toast":
            toast($mensaje, $type)->width('400px');
            break;
    }
    /*alert()->success('SuccessAlert','Lorem ipsum dolor sit amet.');
        alert()->info('InfoAlert','Lorem ipsum dolor sit amet.');
        alert()->warning('WarningAlert','Lorem ipsum dolor sit amet.');
        alert()->error('ErrorAlert','Lorem ipsum dolor sit amet.');
        alert()->question('QuestionAlert','Lorem ipsum dolor sit amet.');
        toast('Success Toast','success');.
        // example:
        alert()->success('Post Created', '<strong>Successfully</strong>')->toHtml();
        // example:
        alert('Title','Lorem Lorem Lorem', 'success')->addImage('https://unsplash.it/400/200');
        // example:
        alert('Title','Lorem Lorem Lorem', 'success')->width('720px');
        // example:
        alert('Title','Lorem Lorem Lorem', 'success')->padding('50px');
        */
    // example:
    //alert()->success('¡Éxito!',$mensaje)->persistent(true,false);
    // example:
    //alert()->success('SuccessAlert','Lorem ipsum dolor sit amet.')->showConfirmButton('Confirm', '#3085d6');
    // example:
    //alert()->question('Are you sure?','You won\'t be able to revert this!')->showCancelButton('Cancel', '#aaa');
    // example:
    //toast('Post Updated','success','top-right')->showCloseButton();
    // example:
    //toast('Post Updated','success','top-right')->hideCloseButton();
    // example:
    /*alert()->question('Are you sure?','You won\'t be able to revert this!')
        ->showConfirmButton('Yes! Delete it', '#3085d6')
        ->showCancelButton('Cancel', '#aaa')->reverseButtons();*/

    // example:
    // alert()->error('Oops...', 'Something went wrong!')->footer('<a href="#">Why do I have this issue?</a>');
    // example:
    //alert()->success('Post Created', 'Successfully')->toToast();
    // example:
    //alert('Title','Lorem Lorem Lorem', 'success')->background('#2acc56');
    // example:
    //()->success('Post Created', 'Successfully')->buttonsStyling(false);
    // example:
    //alert()->success('Post Created', 'Successfully')->iconHtml('<i class="far fa-thumbs-up"></i>');
    // example:
    //alert()->question('Are you sure?','You won\'t be able to revert this!')->showCancelButton()->showConfirmButton()->focusConfirm(true);
    // example:
    //alert()->question('Are you sure?','You won\'t be able to revert this!')->showCancelButton()->showConfirmButton()->focusCancel(true);
    // example:
    //toast('Signed in successfully','success')->timerProgressBar();

}

function verSpinner()
{
    $spinner = '
        <div class="overlay-wrapper" wire:loading>
            <div class="overlay">
                <div class="spinner-border text-navy" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    ';

    return $spinner;
}

function verImagen($path, $user = false)
{
    if (!is_null($path)){
        if (file_exists(public_path('storage/'.$path))){
            return asset('storage/'.$path);
        }else{
            if ($user){
                return asset('img/user.png');
            }
            return asset('img/image.png');
        }
    }else{
        if ($user){
            return asset('img/user.png');
        }
        return asset('img/image.png');
    }
}

function iconoPlataforma($plataforma)
{
    if ($plataforma == 0) {
        return '<i class="fas fa-desktop"></i>';
    } else {
        return '<i class="fas fa-mobile"></i>';
    }
}

function verRole($role, $roles_id)
{
    $roles = [
        '0'     => 'Estandar',
        '1'     => 'Administrador',
        '100'   => 'Root'
    ];

    if (is_null($roles_id)){
        return $roles[$role];
    }else{
        $roles = Parametro::where('tabla_id', '-1')->where('id', $roles_id)->first();
        if ($roles){
            return ucwords($roles->nombre);
        }else{
            return "NO definido";
        }
    }
}

function verEstatusUsuario($i, $icon = null)
{
    if (is_null($icon)){
        $suspendido = "Suspendido";
        $activado = "Activo";
    }else{
        $suspendido = '<i class="fa fa-user-slash"></i>';
        $activado = '<i class="fa fa-user-check"></i>';
    }
    $status = [
        '0' => '<span class="text-danger">'.$suspendido.'</span>',
        '1' => '<span class="text-success">'.$activado.'</span>'/*,
        '2' => '<span class="text-success">Confirmado</span>'*/
    ];
    return $status[$i];
}

function haceCuanto($fecha){
    $carbon = new Carbon();
    return $carbon->parse($fecha)->diffForHumans();
}

function verFecha($fecha, $format = null){
    $carbon = new Carbon();
    if ($format == null){ $format = "j/m/Y"; }
    return $carbon->parse($fecha)->format($format);
}

function numRowsPaginate(){
    $default = 15;
    $parametro = Parametro::where("nombre", "numRowsPaginate")->first();
    if ($parametro) {
        if (is_numeric($parametro->valor)) {
            return $parametro->valor;
        }
    }
    return $default;
}

//-------------------------------------------------------------------------------------


function cuantosDias($fecha_inicio, $fecha_final){

    if ($fecha_inicio == null){
        return 0;
    }

    $carbon = new Carbon();
    $fechaEmision = $carbon->parse($fecha_inicio);
    $fechaExpiracion = $carbon->parse($fecha_final);
    $diasDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
    return $diasDiferencia;
}

function diaEspanol($fecha){
    $diaSemana = date("w",strtotime($fecha));
    $diasEspanol = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $dia = $diasEspanol[$diaSemana];
    return $dia;
}

function mesEspanol($numMes){
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $mes = $meses[$numMes - 1];
    return $mes;
}



//funcion formato millares
function formatoMillares($cantidad, $decimal = 2)
{
    return number_format($cantidad, $decimal, ',', '.');
}

//Ceros a la izquierda
function cerosIzquierda($cantidad, $cantCeros = 2)
{
    if ($cantidad == 0) {
        return 0;
    }
    return str_pad($cantidad, $cantCeros, "0", STR_PAD_LEFT);
}

//calculo de porcentaje
function obtenerPorcentaje($cantidad, $total)
{
    if ($total != 0) {
        $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
        $porcentaje = round($porcentaje, 2);  // Quitar los decimales
        return $porcentaje;
    }
    return 0;
}

//Estado de Tienda Abierto o Cerrada
function estatusTienda($id, $boton = false)
{
    //$estatus = true;
    $estatus_tienda = Parametro::where('nombre', 'estatus_tienda')->where('tabla_id', $id)->first();
    if ($estatus_tienda){

        $estatus = $estatus_tienda->valor;

        if (!$boton){
            if ($estatus == 1){
                $horario = Parametro::where('nombre', 'horario')->where('tabla_id', $id)->first();
                if ($horario && $horario->valor == 1){

                    $hoy = date('D');
                    $dia = Parametro::where('nombre', "horario_$hoy")->where('tabla_id', $id)->first();
                    $apertura = Parametro::where('nombre', 'horario_apertura')->where('tabla_id', $id)->first();
                    $cierre = Parametro::where('nombre', 'horario_cierre')->where('tabla_id', $id)->first();

                    if ($dia && $dia->valor == 1){

                        if($apertura && $cierre){

                            $estatus = hourIsBetween($apertura->valor, $cierre->valor, date('H:i'));

                        }else{
                            $estatus = true;
                        }

                    }else{
                        $estatus = false;
                    }

                }
            }

        }


    }else{
        $estatus = false;
    }

    return $estatus;
}

//Función comprueba una hora entre un rango
function hourIsBetween($from, $to, $input) {
    $dateFrom = DateTime::createFromFormat('!H:i', $from);
    $dateTo = DateTime::createFromFormat('!H:i', $to);
    $dateInput = DateTime::createFromFormat('!H:i', $input);
    if ($dateFrom > $dateTo) $dateTo->modify('+1 day');
    return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);
    /*En la función lo que haremos será pasarle, el desde y el hasta del rango de horas que queremos que se encuentre y el datetime con la hora que nos llega.
Comprobaremos si la segunda hora que le pasamos es inferior a la primera, con lo cual entenderemos que es para el día siguiente.
Y al final devolveremos true o false dependiendo si el valor introducido se encuentra entre lo que le hemos pasado.*/
}

function empresaDefault($default)
{
    if ($default){
        return '<i class="fas fa-certificate text-muted text-xs"></i>';
    }else{
        return false;
    }
}

function verImg($path, $banner = false)
{
    if ($banner){
        $img = 'img/b_img_placeholder.png';
    }else{
        $img = 'img/img_placeholder.png';
    }
    if (!is_null($path)){
        if (file_exists(public_path($path))){
            $img = $path;
        }
    }
    return $img;
}

/*function crearMiniaturas($data, $path, $width = 320, $height = 320)
{
    //$nombre = explode('logo/', $empresa->logo);
    //$path = 'storage/logo/t_'.$nombre[1]
    $img = Image::make($data);
    $img->resize($width, $height);
    $img->save($path);
}*/

/*function calcularIVA($id, $pvp, $iva = false, $label = false)
{
    $resultado = 0;
    //puedes después cambiarlo a 16% si así lo requieres
    $valor_iva = 16;
    $monto_total = $pvp;
    $precio_dolar = 0;

    $dolar = Parametro::where('nombre', 'precio_dolar')->first();
    if ($dolar){
        $precio_dolar = $dolar->valor;
    }

    $parametro = Parametro::where('nombre', 'iva')->first();
    if ($parametro){
        $valor_iva = $parametro->valor;
    }
    if ($label){
        return $valor_iva;
    }


    $producto = Producto::find($id);
    //dd($id);
    if ($producto && $producto->impuesto == 1){
        if ($iva){
            $resultado = ( $monto_total * ( $valor_iva / 100 ) );

        }else{
            $resultado = ( $monto_total ) + ( $monto_total * ( $valor_iva / 100 ) );
        }
    }else{
        if ($iva){
            $resultado = 0;
        }else{
            $resultado = $monto_total;
        }
    }



    //En caso de que quieras redondear a dos decimales, te recomiendo usar la función number_format
    $resultado = number_format($resultado, 2, '.', false);
    return $resultado;
}

function calcularPrecio($id, $pvp, $iva = false, $label = false)
{
    $resultado = 0;
    //puedes después cambiarlo a 16% si así lo requieres
    $valor_iva = 16;
    $monto_total = $pvp;
    $precio_dolar = 1;

    $dolar = Parametro::where('nombre', 'precio_dolar')->first();
    if ($dolar){
        if ($dolar->valor > 0){
            $precio_dolar = $dolar->valor;
        }
    }

    $parametro = Parametro::where('nombre', 'iva')->first();
    if ($parametro){
        $valor_iva = $parametro->valor;
    }
    if ($label){
        return $valor_iva;
    }

    $stock = Stock::find($id);
    $moneda_empresa = $stock->empresa->moneda;
    $moneda_stock = $stock->moneda;

    $producto = Producto::find($stock->productos_id);
    //dd($id);
    if ($producto && $producto->impuesto == 1){
        if ($iva){
            $resultado = ( $monto_total * ( $valor_iva / 100 ) );
            if ($moneda_stock == 'Bs.'){
                $resultado = $resultado / $precio_dolar;
            }
        }else{
            $resultado = ( $monto_total ) + ( $monto_total * ( $valor_iva / 100 ) );
            if ($moneda_stock == 'Bs.'){
                $resultado = $resultado / $precio_dolar;
            }
        }
    }else{
        if ($iva){
            $resultado = 0;
        }else{
            $resultado = $monto_total;
        }
    }



    //En caso de que quieras redondear a dos decimales, te recomiendo usar la función number_format
    $resultado = number_format($resultado, 2, '.', false);
    return $resultado;
}

function verIconoEstatusPedico($estatus)
{
    $status = [
        '0' => '<i class="fas fa-exclamation-triangle text-warning"></i>',
        '1' => '<i class="fas fa-money-check-alt text-info"></i>',
        '2' => '<i class="fas fa-shipping-fast"></i>',
        '3' => '<i class="fas fa-check-circle text-success"></i>',
        '4' => '<i class="fas fa-exclamation-triangle text-danger"></i>'
    ];
    return $status[$estatus];
}

function verIconoMetodosPago($metodo)
{
    $status = [
        'efectivo' => '<i class="fas fa-money-bill-wave"></i>',
        'debito' => '<i class="far fa-credit-card"></i>',
        'transferencia' => '<i class="fas fa-money-check"></i>',
        'movil' => '<i class="fas fa-mobile-alt"></i>'
    ];
    return $status[$metodo];
}

function telefonoSoporte()
{
    $parametro = Parametro::where('nombre', 'telefono_soporte')->first();
    if ($parametro){
        $telefono = strtoupper($parametro->valor);
    }else{
        $telefono = "0212.999.99.99";
    }
    return $telefono;
}

function verTipoCategoria($categoria)
{
    $categorias = [
        '0' => 'Productos',
        '1' => 'Tiendas',
    ];

    if(array_key_exists($categoria, $categorias)){
        return $categorias[$categoria];
    }else{
        return "NO DEFINIDA";
    }

}*/
