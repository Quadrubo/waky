<x-filament::page>
    <div
        x-data="{}"
        x-init="
            window.addEventListener('EchoLoaded', () => {
                window.Echo.private('computers')
                    .listen('ComputerReachableStatusUpdated', () => {
                        $wire.loadComputers();
                    });
                window.Echo.private('App.Models.User.{{ Auth::id() }}')
                    .notification((notification) => {
                        $wire.displayNotification(notification);
                    });
            })
        "
    ></div>

    {{-- <script>
    Echo.private(`App.Models.User.${usePage().props.user.id}`).notification((notification) => {
        notifications.value.push(notification);
    });
    </script> --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">

        @foreach ($computers as $computer)
        <livewire:computer-widget wire:key="{{ $computer->id }}" :computer="$computer" />
        @endforeach

    </div>
</x-filament::page>