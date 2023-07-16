<?php

namespace App\Filament\Pages;

use App\Actions\PingComputersAction;
use App\Models\Computer;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class WakeComputers extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-desktop-computer';

    protected static string $view = 'filament.pages.wake-computers';

    public Collection $computers;

    /**
     * Livewire echo integration currently broken in filament.
     * Echo listening implemented in the view.
     *
     * @see https://github.com/filamentphp/filament/issues/5914
     */
    // protected $listeners = ['echo-private:computers,ComputerReachableStatusUpdated' => 'loadComputers'];

    public function mount()
    {
        $this->loadComputers();
    }

    protected function getActions(): array
    {
        return [
            Action::make('refresh')
                ->color('secondary')
                ->icon('heroicon-s-refresh')
                ->action(function (PingComputersAction $pingComputersAction) {
                    $pingComputersAction->execute();
                }),
        ];
    }

    public function displayNotification($notification)
    {
        $filamentNotification = Notification::make()
            ->title($notification['title'])
            ->body($notification['body']);

        if ($notification['level'] === 'info') {
            // TODO: get this working
            // ->iconColor('blue')
            $filamentNotification->icon('heroicon-o-information-circle');
        } elseif ($notification['level'] === 'success') {
            $filamentNotification->success();
        } elseif ($notification['level'] === 'warning') {
            $filamentNotification->warning();
        } elseif ($notification['level'] === 'danger') {
            $filamentNotification->danger();
        }

        $filamentNotification->send();
    }

    public function loadComputers()
    {
        $this->computers = Computer::all();
    }
}
