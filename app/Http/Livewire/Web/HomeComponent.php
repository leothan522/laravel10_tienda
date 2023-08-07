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
            ->whereRelation('articulo', 'estatus', 1)
            ->orderBy('vendido', 'desc')
            ->get();

        $recientes = Stock::where('almacen_principal', 1)
            ->where('estatus', 1)
            ->whereRelation('articulo', 'estatus', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        recorrerCategorias($categorias);
        recorrerStock($destacados);
        recorrerStock($recientes);

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

    private function listarOfertas()
    {
        $hoy = date("Y-m-d H:i:s");
        $resultado = null;
        $ofertas = Oferta::where('desde', '<=', $hoy)
            ->where('hasta', '>=', $hoy)
            ->get();
        if ($ofertas->isNotEmpty()){

            $ofertas->each(function ($oferta){
                $oferta->mostrar = true;
                if ($oferta->afectados == 0){
                    $oferta->titulo = $oferta->empresa->nombre;
                    $oferta->imagen = $oferta->empresa->mini;
                    $oferta->boton = "Ver Tienda";
                    $oferta->url = "#";
                }
                if ($oferta->afectados == 1){
                    $oferta->titulo = $oferta->categoria->nombre;
                    $oferta->imagen = $oferta->categoria->mini;
                    $oferta->boton = "Ver Categoria";
                    $oferta->url = "#";
                }
                if ($oferta->afectados == 2){
                    $oferta->titulo = $oferta->articulo->descripcion;
                    $oferta->imagen = $oferta->articulo->mini;
                    $oferta->boton = 'Ver Producto';

                    $stock = Stock::where('empresas_id', $oferta->empresas_id)
                        ->where('almacen_principal', 1)
                        ->where('articulos_id', $oferta->articulos_id)
                        ->first();
                    if ($stock && $stock->articulo->estatus){
                        $oferta->url = route('web.detail', $stock->id);
                    }else{
                        $oferta->mostrar = false;
                    }

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

    public function noCategoriaStock()
    {
        $this->confirm('Stock NO disponible', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => false,
            'text' => '¡Pronto tendremos Productos en esta categoria!',
            'cancelButtonText' => 'OK',
        ]);
    }

    public function cerrarModalLogin($nombre)
    {
        //cerrar con JS el modal
    }


}
