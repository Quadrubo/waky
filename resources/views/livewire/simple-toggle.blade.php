<div class="flex flex-row gap-2">
    <button 
        x-data="{
            state: @entangle('state'),
            users: @entangle('users'),
        }"
        :aria-checked="state"
        x-on:click="state = ! state; state ? users++ : users--; $wire.useOrUnuse();"
        wire:loadling.attr="disabled"
        type="button"
        class="
            {{
                match ($this->getColor()) {
                    'green' => 'bg-green-500',
                    'orange' => 'bg-orange-500',
                    'gray' => 'bg-gray-200',
                }
            }}
            relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent outline-none transition-colors duration-200 ease-in-out disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-70"
    >
        <span
            x-bind:class="{
                'translate-x-5 rtl:-translate-x-5': state,
                'translate-x-0': ! state,
            }"
            class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        >
        </span>
    </button>

    <span>
        {{ $users }} {{ $users === 1 ? 'User' : 'Users' }}
    </span>
</div>