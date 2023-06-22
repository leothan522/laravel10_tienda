<?php

namespace App\Exports;

use App\Models\Ajuste;
use Maatwebsite\Excel\Concerns\FromCollection;

class AjustesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ajuste::all();
    }
}
