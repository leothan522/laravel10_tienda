<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Counter extends Component
{
    use LivewireAlert;
    public $count = 0, $select = "hola";

    protected $listeners = ['increment', 'prueba'];


    public function increment($texto)

    {
        $this->alert('success', 'Basic Alert');
        $this->count = $texto;

    }

    public function prueba($array)
    {
        $json = crearJson($array);
        $this->select = $json;
        if (leerJson($json, 1))
        {
            $this->select = "ya tengo el poder";
        }

    }

    public function render()
    {
        return view('livewire.counter');
    }

}
