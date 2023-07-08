<?php

namespace App\Http\Livewire\Web;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\Stock;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HomeComponent extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'cerrarModalLogin'
    ];

    public $login_email, $login_password;

    public function render()
    {
        $ofertas = $this->listarOfertas();
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $empresas = Empresa::get();

        $destacados = Stock::where('almacen_principal', 1)
            ->where('estatus', 1)
            ->orderBy('vendido', 'desc')
            ->get();

        $recientes = Stock::where('almacen_principal', 1)
            ->where('estatus', 1)
            ->orderBy('created_at', 'asc')
            ->get();


        $this->recorrerStock($destacados);
        $this->recorrerStock($recientes);

        return view('livewire.web.home-component')
            ->with('listarOfertas', $ofertas)
            ->with('listarCategorias', $categorias)
            ->with('listarEmpresas', $empresas)
            ->with('listarDestacados', $destacados)
            ->with('listarRecientes', $recientes)
            ;
    }

    public function login()
    {
        $rules = [
            'login_email'       => ['required', 'email', Rule::exists('users', 'email')],
            'login_password'    => 'required'
        ];

        $messages = [
            'login_email.required'       => 'El email es obligatorio.',
            'login_email.email'       => 'El email no es un correo válido.',
            'login_email.exists'       => 'El email seleccionado es inválido.',
            'login_password.required'       => 'La contresaña es obligatoria.'
        ];

        $this->validate($rules, $messages);

        $credentials = [
            'email'     =>  $this->login_email,
            'password'  =>  $this->login_password
        ];

        if (Auth::attempt($credentials)){
            $this->emit('cerrarModalLogin', Auth::user()->name);
        }else{
            $this->addError('login_validacion', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
        }

    }

    public function cerrarModalLogin($nombre)
    {
        //cerrar con JS el modal
    }



    private function listarOfertas()
    {
        $hoy = date("Y-m-d H:i:s");
        $resultado = null;
        $ofertas = Oferta::where('desde', '<=', $hoy)
            ->where('hasta', '>=', $hoy)
            ->get();
        if ($ofertas->isNotEmpty()){

            $ofertas->each(function ($oferta){
                if ($oferta->afectados == 0){
                    $oferta->titulo = $oferta->empresa->nombre;
                    $oferta->imagen = $oferta->empresa->mini;
                    $oferta->boton = "Ver Tienda";
                }
                if ($oferta->afectados == 1){
                    $oferta->titulo = $oferta->categoria->nombre;
                    $oferta->imagen = $oferta->categoria->mini;
                    $oferta->boton = "Ver Categoria";
                }
                if ($oferta->afectados == 2){
                    $oferta->titulo = $oferta->articulo->descripcion;
                    $oferta->imagen = $oferta->articulo->mini;
                    $oferta->boton = 'Ver Producto';
                }
            });

            if($ofertas->count() >= 2){
                $resultado = $ofertas->random(2);
            }else{
                $resultado = $ofertas;
            }
        }
        return $resultado;
    }

    private function recorrerStock($stock)
    {
        $stock->each(function ($stock) {

            $articulo = Articulo::find($stock->articulos_id);
            $unidad = Unidad::find($stock->unidades_id);

            $stock->nombre = $articulo->descripcion;
            $stock->imagen = $articulo->mini;
            $stock->unidad = $unidad->codigo;
            $stock->mostrar = true;

            if (!$articulo->estatus){
                $stock->mostrar = false;
            }

            $resultado = calcularPrecios($stock->empresas_id, $stock->articulos_id, $articulo->tributarios_id, $stock->unidades_id);
            $stock->moneda = $resultado['moneda_base'];
            $stock->dolares = $resultado['precio_dolares'];
            $stock->bolivares = $resultado['precio_bolivares'];
            $stock->iva_dolares = $resultado['iva_dolares'];
            $stock->iva_bolivares = $resultado['iva_bolivares'];
            $stock->neto_dolares = $resultado['neto_dolares'];
            $stock->neto_bolivares = $resultado['neto_bolivares'];
            $stock->oferta_dolares = $resultado['oferta_dolares'];
            $stock->oferta_bolivares = $resultado['oferta_bolivares'];
            $stock->porcentaje = $resultado['porcentaje'];

            if ($stock->moneda == "Dolares" && !$stock->dolares){
                $stock->mostrar = false;
            }

            if ($stock->moneda == "Bolivares" && !$stock->bolivares){
                $stock->mostrar = false;
            }



        });
    }

}
