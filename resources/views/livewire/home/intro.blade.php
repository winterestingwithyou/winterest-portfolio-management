<?php

use Livewire\Volt\Component;
use App\Models\Home;
use App\Http\Requests\UpdateHomeIntroRequest;

new class extends Component {
    public string $intro_id;
    public string $intro_en;

    public function mount(): void
    {
        $home = Home::first();
        $this->intro_id = $home->intro_id;
        $this->intro_en = $home->intro_en;
    }

    /**
     * Handle update intro request
     */
    public function update()
    {
        $validated = $this->validate([
            'intro_id' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!str_contains($value, '{alias}') || !str_contains($value, '{realname}')) {
                    $fail("Kolom Intro Indonesia harus mengandung {alias} dan {realname}.");
                }
            }],
            'intro_en' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!str_contains($value, '{alias}') || !str_contains($value, '{realname}')) {
                    $fail("Field English Intro must contain {alias} and {realname}.");
                }
            }],
        ]);

        $home = Home::first();

        if ($home) {
            $home->update($validated);
            session()->flash('success', 'Data berhasil diperbarui.');
        } else {
            session()->flash('error', 'Data tidak dapat diperbarui');
        }
    }
}; ?>

<div>
    @if (session()->has('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-800 px-4 py-3"
        >
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-800 px-4 py-3"
        >
            {{ session('error') }}
        </div>
    @endif
    <form wire:submit="update">
        <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-gray-900 mb-5 dark:text-white">Intro</h2>
            
            <div class="mb-5">
                <x-input-label for="intro_id" :value="__('Bahasa Indonesia')" class="font-semibold" />
                <x-text-input wire:model="intro_id" id="Intro Indonesia" class="mt-1 w-full" type="text" name="Intro Indonesia" required />
                <x-input-error :messages="$errors->get('intro_id')" class="mt-2" />
            </div>
            
            <div class="mb-5">
                <x-input-label for="intro_en" :value="__('Bahasa Inggris')" class="font-semibold" />
                <x-text-input wire:model="intro_en" id="English Intro" class="mt-1 w-full" type="text" name="English Intro" required />
                <x-input-error :messages="$errors->get('intro_en')" class="mt-2" />
            </div>
        
            <div class="flex justify-end">
                <x-primary-button class="ms-4">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>
