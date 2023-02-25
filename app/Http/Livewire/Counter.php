<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Counter extends Component
{
    use LivewireAlert;
    public $count = 0;



    public function increment()

    {
        $this->alert('success', 'Basic Alert');
        $this->count++;

    }
    public function render()
    {
        return view('livewire.counter');
    }
}
