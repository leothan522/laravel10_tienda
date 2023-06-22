<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ArticulosExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ArticulosController extends Controller
{
    public function index()
    {
        return view('dashboard.articulos.index');
    }

    public function reporteArticulos(Request $request)
    {
        //return $request->all();
        return Excel::download(new ArticulosExport(), 'Articulos.xlsx');
    }
}
