<?php

namespace App\Exports;

use App\Models\Articulo;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticulosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Articulo::all();
    }
}
