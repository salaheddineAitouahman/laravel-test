<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $property->name }}
            </h2>
            <a href="{{ route('properties.index') }}" class="text-sm text-primary hover:text-secondary">{{ __('← Retour aux propriétés') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <p class="text-gray-700 whitespace-pre-line">{{ $property->description }}</p>
                    <p class="mt-6 text-xl">
                        <span class="text-primary font-semibold">{{ number_format($property->price_per_night, 0, ',', ' ') }} €</span>
                        <span class="text-gray-500"> / nuit</span>
                    </p>
                    @auth
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            @livewire('booking-manager', ['property' => $property])
                        </div>
                    @else
                        <p class="mt-6 text-gray-500">
                            <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">{{ __('Connectez-vous') }}</a>
                            {{ __('pour réserver cette propriété.') }}
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
