<?php

namespace App\Http\Livewire;

use App\Actions\ShutdownComputerAction;
use App\Actions\WakeComputerAction;
use App\Models\Computer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ComputerWidget extends Component
{
    public bool $used;

    public int $users;

    public Computer $computer;

    public function mount()
    {
        $this->users = $this->computer->users->count();
        $this->used = $this->computer->users->contains(Auth::user());
    }

    public function wakeOrShutdown($computerID, WakeComputerAction $wakeComputerAction, ShutdownComputerAction $shutdownComputerAction)
    {
        $computer = Computer::find($computerID);

        if ($computer->status === 'on') {
            $shutdownComputerAction->execute($computer);

            return;
        }

        $wakeComputerAction->execute($computer);
    }

    public function getLastOnlineStatus(): string
    {
        if ($this->computer->status_updated_at) {
            return Carbon::make($this->computer->status_updated_at)->format('d.m.Y H:i');
        }

        return '';
    }

    public function render()
    {
        return view('livewire.computer-widget');
    }
}
