<?php

use Livewire\Volt\Component;
use App\Models\Home;

new class extends Component {
    public String $myself_id;
    public String $myself_en;

    public function mount(): void
    {
        $home = Home::first();
        $this->myself_id = $home->myself_id;
        $this->myself_en = $home->myself_en;
    }

    public function update()
    {
         $validated = $this->validate([
            'myself_id' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!str_contains($value, '{alias}') || !str_contains($value, '{realname}') || !str_contains($value, "{'|'}") || !str_contains($value, '{bias}')) {
                    $fail("Kolom Myself Indonesia harus mengandung {alias}, {realname}, {'|'}, dan {bias}.");
                }
            }],
            'myself_en' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!str_contains($value, '{alias}') || !str_contains($value, '{realname}') || !str_contains($value, "{'|'}") || !str_contains($value, '{bias}')) {
                    $fail("Field English Myself must contain {alias}, {realname}, {'|'}, and {bias}.");
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
            <h2 class="text-xl font-bold text-gray-900 mb-5 dark:text-white">Myself</h2>
        
            <div class="mb-5">
                <x-input-label for="myself_id" :value="__('Bahasa Indonesia')" class="font-semibold" />
                <x-text-input wire:model="myself_id" id="Diriku Indonesia" class="mt-1 w-full" type="text" name="Diriku Indonesia" required />
                <x-input-error :messages="$errors->get('myself_id')" class="mt-2" />
            </div>
            
            <div class="mb-5">
                <x-input-label for="myself_en" :value="__('Bahasa Inggris')" class="font-semibold" />
                <x-text-input wire:model="myself_en" id="Myself English" class="mt-1 w-full" type="text" name="Myself English" required />
                <x-input-error :messages="$errors->get('myself_en')" class="mt-2" />
            </div>
        
            <div class="flex justify-end">
                <x-primary-button class="ms-4">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>