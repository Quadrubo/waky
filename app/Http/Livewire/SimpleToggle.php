<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SimpleToggle extends Component
{
    public bool $state;

    public int $users;

    public bool $used;

    public int $computerID;

    public function mount()
    {
        $this->state = $this->used;
    }

    public function getColor(): string
    {
        if ($this->state) {
            return 'green';
        } elseif ($this->users > 0) {
            return 'orange';
        } else {
            return 'gray';
        }
    }

    public function updated($property)
    {
        if ($property === 'state') {
            $this->emit('useStateUpdated', $this->computerID);
        }
    }

    public function render()
    {
        return view('livewire.simple-toggle');
    }
}
