<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecuperarRequest;
use App\Models\Categoria;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{

    private function getCategorias()
    {
        return Categoria::get();
    }

    public function index()
    {
        return view('web.multishop.index')
            ->with('listarCategorias', $this->getCategorias())
            ->with('view', 'inicio')
            ;
    }

    public function perfil()
    {
        return view('web.multishop.perfil.index');
    }

    public function detail($id)
    {
        $stock = Stock::findOrFail($id);

        return view('web.multishop.detail.index')
            ->with('listarCategorias', $this->getCategorias())
            ->with('view', 'detail')
            ->with('stock_id', $id)
            ;
    }

    public function categoria($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('web.multishop.shop.index')
            ->with('listarCategorias', $this->getCategorias())
            ->with('view', 'categoria')
            ->with('shop_id', $id)
            ;
    }

    public function shop()
    {
        return view('web.multishop.shop.index');
    }

    public function cart()
    {
        return view('web.multishop.cart.index');
    }

    public function checkout()
    {
        return view('web.multishop.checkout.index');
    }

    public function contact()
    {
        return view('web.multishop.contact.index');
    }

    public function recuperar($token, $email)
    {
        return view('web.reset-password')
            ->with('email', $email)
            ->with('token', $token);
    }

    public function reset(RecuperarRequest $request)
    {
        $hoy = Carbon::now();
        $user = User::where('email', $request->email)->first();
        $id = $user->id;
        $token = $user->token_recuperacion;
        $times = $user->times_recuperacion;
        $user = User::find($id);
        if ($token == $request->token && $times){
            $times = Carbon::parse($times);
            $vencido = $times->diffInHours($hoy);
            if (!$vencido){
                $user->password = Hash::make($request->password);
                verSweetAlert2('Su contraseña ha sido restablecida.');
            }else{
                verSweetAlert2('Enlace de restablecimiento vencido.', 'toast', 'warning');
            }
        }else{
            verSweetAlert2('Enlace de restablecimiento vencido.', 'toast', 'warning');
        }
        $user->token_recuperacion = null;
        $user->times_recuperacion = null;
        $user->save();
        return redirect()->route('web.index');
    }
}
