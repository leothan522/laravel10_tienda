<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Counter extends Component
{
    use LivewireAlert;
    public $count = 0;

    protected $listeners = ['increment'];


    public function increment($texto)

    {
        $this->alert('success', 'Basic Alert');
        $this->count = $texto;

    }
    public function render()
    {
        return view('livewire.counter');
    }
}
