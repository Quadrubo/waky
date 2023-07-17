<div class="rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-6 space-y-2">
    <style>
        .hover-shadow:hover {
            filter: drop-shadow(0px 0px 10px rgb(175,175,175));
        }
        
        .hover-shadow:active {
            filter: drop-shadow(0px 0px 10px rgb(125, 125, 125));
        }
    </style>
     
    <div class="flex flex-row justify-between">
        <p class="text-2xl font-semibold">{{ $computer->name }}</p>

        {{-- Power Button --}}
        <button type="button" wire:click="wakeOrShutdown({{ $computer->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                class="
                {{
                    match ($computer?->status) {
                        'on' => 'text-success-600 hover:text-success-500 focus:text-success-700 focus:ring-offset-success-700',
                        'off' => 'text-danger-600 hover:text-danger-500 focus:text-danger-700 focus:ring-offset-danger-700',
                        null => 'text-gray-600 hover:text-gray-500 focus:text-gray-700 focus:ring-offset-gray-700',
                    }
                }}
                w-8 h-8 hover-shadow transition-all"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
            </svg> 
        </button>
    </div>

    <div class="flex flex-col">
        <span class="text-gray-700 dark:text-gray-200">{{ $computer->ip_address }}</span>
        <span class="text-gray-700 dark:text-gray-200">{{ $computer->mac_address }}</span>
    </div>


    <livewire:simple-toggle :used="$used" :users="$users" :computerID="$computer->id">
    </livewire:simple-toggle>

    <div>
        <span class="text-gray-700 dark:text-gray-200">
            Status last updated {{ $this->getLastOnlineStatus() }}
        </span>
    </div>
</div>