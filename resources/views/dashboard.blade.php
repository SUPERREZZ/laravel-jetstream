<x-app-layout>
    <x-slot name="header">
        <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h4>
    </x-slot>
    <div class="flex flex-col">
        @livewire('chat')
    </div>
</x-app-layout>
