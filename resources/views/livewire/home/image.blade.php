<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;
use WireUi\Traits\Actions;
use App\Models\Home;

new class extends Component {
    use Actions;

    public String $image;

    public function mount(): void 
    {
        $home = Home::first();
        $this->image = $home->image;        
    }

    /**
     * Rules for validate image url
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required', 'string', 'url',
                function ($attribute, $value, $fail) {
                    try {
                        $response = Http::head($value);

                        $contentType = $response->header('Content-Type');

                        if (!$contentType || !str_starts_with($contentType, 'image/')) {
                            $fail("URL tidak mengarah ke gambar. Content-Type: $contentType");
                        }
                    } catch (\Exception $e) {
                        $fail("Gagal mengakses URL gambar: " . $e->getMessage());
                    }
                },
            ],
        ];
    }

    /**
     * Handle update image request
     */
    public function update(): void
    {
        $validated = $this->validate();

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

    /**
     * Reset Image value to default with database value
     */
    public function resetImage(): void
    {
        $home = Home::first();
        $this->image = $home->image; 
    }

    /**
     * load preview image from input
     */
    public function loadPreview(): void
    {
        $this->validate();        
    }
}; ?>

<div class="h-full">
    <form wire:submit="update" class="h-full">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl h-full shadow-md">
            <h2 class="text-xl font-bold text-gray-900 mb-5 dark:text-white">Gambar</h2>
            
            <div class="aspect-[9/10] bg-gray-200 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center mb-5">
                @if ($image)
                    <img src="{{ $image }}" alt="Preview" class="object-cover w-full h-full rounded-lg aspect-[9/10] object-top grayscale-0 dark:grayscale">
                @else
                    <svg class="w-16 h-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                @endif
            </div>
            
            <div class="mb-5">
                <x-input wire:model="image" :label="__('Image Url')" required />
            </div>
        
            <div class="flex justify-end">
                <x-button type="button" wire:click="resetImage" icon="refresh" />
                <x-button type="button" wire:click="loadPreview" secondary class="ms-4 text-xs uppercase font-semibold tracking-widest">
                    {{ __('Preview') }}
                </x-button>
                <x-button type="submit" primary class="ms-4 text-xs uppercase font-semibold tracking-widest">
                    {{ __('Save') }}
                </x-button>
            </div>
        </div>
    </form>
</div>