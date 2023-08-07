<?php

namespace App\Http\Livewire\Web;

use App\Models\Articulo;
use App\Models\ArtImg;
use App\Models\Stock;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DetailComponent extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'cerrarModalLogin'
    ];

    public $login_email, $login_password;
    public $stock_id;

    public function mount($stock_id)
    {
        $this->stock_id = $stock_id;
    }

    public function render()
    {
        $stock = Stock::find($this->stock_id);
        $this->detallesStock($stock);

        $destacados = Stock::where('almacen_principal', 1)
            ->where('estatus', 1)
            ->where('id', '!=', $this->stock_id)
            ->where('empresas_id', $stock->empresas_id)
            ->orderBy('vendido', 'desc')
            ->get();
        $this->recorrerStock($destacados);

        return view('livewire.web.detail-component')
            ->with('stock', $stock)
            ->with('listarStock', $destacados);
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

    private function detallesStock($stock)
    {
        $stock->nombre = $stock->articulo->descripcion;
        $stock->codigo = $stock->articulo->codigo;
        $stock->imagen = $stock->articulo->mini;
        $stock->unidad = $stock->unidad->codigo;
        $stock->categoria = $stock->articulo->categoria->nombre;
        $stock->categorias_id = $stock->articulo->categorias_id;
        $stock->marca = $stock->articulo->marca;
        $stock->modelo = $stock->articulo->modelo;
        $stock->referencia = $stock->articulo->referencia;
        $stock->adicional = $stock->articulo->adicional;
        $stock->galeria = ArtImg::where('articulos_id', $stock->articulos_id)->get();

        $resultado = calcularPrecios($stock->empresas_id, $stock->articulos_id, $stock->articulo->tributarios_id, $stock->unidades_id);
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

            if (!$articulo->estatus) {
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

            if ($stock->moneda == "Dolares" && !$stock->dolares) {
                $stock->mostrar = false;
            }

            if ($stock->moneda == "Bolivares" && !$stock->bolivares) {
                $stock->mostrar = false;
            }

        });
    }


}
