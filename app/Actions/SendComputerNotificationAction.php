<?php
namespace App\Actions;

use App\Jobs\ShutdownComputer;
use App\Models\Computer;
use App\Models\DiscordWebhook;
use App\Models\Habit;
use App\Models\User;
use App\Notifications\UseComputerNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Notification;
use Spatie\Ssh\Ssh;

class SendComputerNotificationAction
{
    public function execute(Computer $computer, int $countBefore, int $countAfter)
    {        
        if ($computer->users()->count() !== $countAfter) {
            //
            return back();
        }

        // Cancel if the count neither went to 0 or from 0
        if (!(($countBefore === 1 && $countAfter === 0) || ($countBefore === 0 && $countAfter === 1))) {
            //
            return back();
        }

        if (config('services.discord.webhook_url')) {
            Notification::route('webhook', config('services.discord.webhook_url'))
                ->notify(new UseComputerNotification(
                    computerName: $computer->name,
                    computerInUse: $computer->isInUse(),
                    timestamp: Carbon::now(),
                ));
        }
    }
}
