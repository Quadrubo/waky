<?php

namespace App\Http\Livewire;

use App\Actions\UnuseComputerAction;
use App\Actions\UseComputerAction;
use App\Models\Computer;
use Illuminate\Support\Facades\Auth;
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

    public function useOrUnuse(UseComputerAction $useComputerAction, UnuseComputerAction $unuseComputerAction)
    {
        $computer = Computer::find($this->computerID);

        if ($computer->users->contains(Auth::user())) {
            $unuseComputerAction->execute($computer);

            return;
        }

        $useComputerAction->execute($computer);
    }

    public function render()
    {
        return view('livewire.simple-toggle');
    }
}
