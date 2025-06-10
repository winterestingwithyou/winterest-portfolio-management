<?php

use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use App\Models\Home;

new class extends Component {
    use Actions;

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
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diperbarui.',                
            );
        } else {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = 'Data tidak dapat diperbarui',   
            );
        }
    }
}; ?>

<div>
    <form wire:submit="update">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-gray-900 mb-5 dark:text-white">Intro</h2>
            
            <div class="mb-5">
                <x-input wire:model="intro_id" :label="__('Bahasa Indonesia')" required />
            </div>
            
            <div class="mb-5">
                <x-input wire:model="intro_en" :label="__('Bahasa Inggris')" required />
            </div>
        
            <div class="flex justify-end">
                <x-button type="submit" primary class="ms-4 text-xs uppercase font-semibold tracking-widest">
                    {{ __('Save') }}
                </x-button>
            </div>
        </div>
    </form>
</div>
