<?php

namespace App\Http\Livewire\Web;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Oferta;
use App\Models\Stock;
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
        $stock = Stock::get();

        return view('livewire.web.home-component')
            ->with('listarOfertas', $ofertas)
            ->with('listarCategorias', $categorias)
            ->with('listarEmpresas', $empresas)
            ->with('listarStock', $stock)
            ;
    }

    public function prueba()
    {
        $this->alert('success', 'Hola');
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

}
