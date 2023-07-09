<?php

namespace App\Http\Livewire\Web;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Stock;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'cerrarModalLogin', 'cerrarCargando'
    ];

    public $login_email, $login_password;
    public $shop_view, $shop_id;
    public $verProductos = true, $verCategoria = false;

    public function mount($view, $shop_id)
    {
        $this->shop_view = $view;
        $this->shop_id = $shop_id;
    }

    public function render()
    {

        $shop = $this->getShop();
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $destacados = Stock::where('almacen_principal', 1)
            ->where('estatus', 1)
            ->orderBy('vendido', 'desc')
            ->orderBy('disponible', 'desc')
            ->paginate(12);

        $this->recorrerStock($destacados);

        return view('livewire.web.shop-component')
            ->with('view', $this->shop_view)
            ->with('shop_id', $this->shop_id)
            ->with('shop', $shop)
            ->with('listarCategorias', $categorias)
            ->with('listarStock', $destacados)
            ;
    }

    private function getShop()
    {
        $shop = null;
        $filtros = array();
        $values = array();

        if ($this->shop_view == 'categoria') {
            $shop = Categoria::find($this->shop_id);
            $empresas = Empresa::get();
            foreach ($empresas as $empresa){
                $contador = 0;
                $stock = Stock::select(['empresas_id', 'articulos_id', 'unidades_id', 'estatus', 'almacen_principal'])
                    ->groupBy('empresas_id', 'articulos_id', 'unidades_id', 'estatus', 'almacen_principal')
                    ->having('empresas_id', $empresa->id)
                    ->having('estatus', 1)
                    ->having('almacen_principal', 1)
                    ->get();
                foreach ($stock as $valor){
                    if ($valor->articulo->categorias_id == $this->shop_id){
                        $contador++;
                    }
                }
                $empresa->value = $contador;
            }
            $filtros[] = [
                'label' => 'Tienda',
                'array' => $empresas
            ];
        }

        $shop->filtros = $filtros;

        return $shop;
    }

    public function btnVerCategoria()
    {
        $this->verProductos = false;
        $this->verCategoria = true;
        $this->emit('cerrarCargando');
    }

    public function login()
    {
        $rules = [
            'login_email' => ['required', 'email', Rule::exists('users', 'email')],
            'login_password' => 'required'
        ];

        $messages = [
            'login_email.required' => 'El email es obligatorio.',
            'login_email.email' => 'El email no es un correo válido.',
            'login_email.exists' => 'El email seleccionado es inválido.',
            'login_password.required' => 'La contresaña es obligatoria.'
        ];

        $this->validate($rules, $messages);

        $credentials = [
            'email' => $this->login_email,
            'password' => $this->login_password
        ];

        if (Auth::attempt($credentials)) {
            $this->emit('cerrarModalLogin', Auth::user()->name);
        } else {
            $this->addError('login_validacion', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
        }

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

            if ($this->shop_view == 'categoria' && $articulo->categorias_id != $this->shop_id){
                $stock->mostrar = false;
            }

        });
    }

    public function cerrarModalLogin($nombre)
    {
        //cerrar con JS el modal
    }

    public function cerrarCargando()
    {
        //cerrar con JS el modal
    }

}
