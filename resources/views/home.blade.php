<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 flex flex-col gap-8">                    
                        {{-- Memanggil komponen Livewire Volt untuk Intro --}}
                        <livewire:home.intro />                        
                        {{-- Memanggil komponen Livewire Volt untuk Explain --}}
                        <livewire:home.myself />                        
                    </div>
                    <div class="lg:col-span-1">                    
                        {{-- Memanggil komponen Livewire Volt untuk Gambar --}}
                        <livewire:home.image />                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
