<?php

use Livewire\Volt\Component;
use App\Models\Home;
use Illuminate\Support\Facades\Http;

new class extends Component {
    public String $image;

    public function mount(): void 
    {
        $home = Home::first();
        $this->image = $home->image;        
    }

    /**
     * Validate rules for image url
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
            session()->flash('success', 'Data berhasil diperbarui.');
        } else {
            session()->flash('error', 'Data tidak dapat diperbarui');
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
    <form wire:submit="update" class="h-full">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl h-full shadow-md">
            <h2 class="text-xl font-bold text-gray-900 mb-5 dark:text-white">Gambar</h2>
            
            <div class="aspect-[9/10] bg-gray-200 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center mb-5">
                @if ($image)
                    <img src="{{ $image }}" alt="Preview" class="object-cover w-full h-full rounded-lg aspect-[9/10] object-top">
                @else
                    <svg class="w-16 h-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                @endif
            </div>
            
            <div class="mb-5">
                <x-input-label for="image" :value="__('Image Url')" class="font-semibold" />
                <x-text-input wire:model="image" id="image" class="mt-1 w-full" type="text" name="image" value="{{ old('image', $home->image ?? '') }}" required />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
        
            <div class="flex justify-end">
                <button type="button" wire:click="resetImage" class="flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-5 h-5" viewBox="0 0 24 24" 
                        fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <path d="M3.51 15a9 9 0 1 0 .49-5.5L1 10"></path>
                    </svg>
                </button>
                <x-secondary-button wire:click="loadPreview" class="ms-4">
                    {{ __('Preview') }}
                </x-secondary-button>
                <x-primary-button class="ms-4">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>