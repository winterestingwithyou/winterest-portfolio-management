<?php

use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use App\Models\Home;

new class extends Component {
    use Actions;

    public String $myself_id;
    public String $myself_en;

    public function mount(): void
    {
        $home = Home::first();
        $this->myself_id = $home->myself_id;
        $this->myself_en = $home->myself_en;
    }

    /**
     * Handle update intro request
     */
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
            <h2 class="text-xl font-bold text-gray-900 mb-5 dark:text-white">Myself</h2>
        
            <div class="mb-5">
                <x-input wire:model="myself_id" :label="__('Bahasa Indonesia')" required />
            </div>
            
            <div class="mb-5">
                <x-input wire:model="myself_en" :label="__('Bahasa Inggris')" required />
            </div>
        
            <div class="flex justify-end">
                <x-button type="submit" primary class="ms-4 text-xs uppercase font-semibold tracking-widest">
                    {{ __('Save') }}
                </x-button>                
            </div>
        </div>
    </form>
</div>