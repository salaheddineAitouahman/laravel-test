<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <a href="{{ route('properties.index') }}" class="text-primary hover:text-secondary font-medium ms-2">→ Voir les propriétés</a>
                </div>
            </div>

            @if($bookings = auth()->user()->bookings()->with('property')->latest()->take(5)->get())
                @if($bookings->isNotEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-800 mb-3">{{ __('Vos dernières réservations') }}</h3>
                            <ul class="divide-y divide-gray-200">
                                @foreach($bookings as $booking)
                                    <li class="py-2 flex justify-between items-center">
                                        <span>{{ $booking->property->name }}</span>
                                        <span class="text-sm text-gray-600">{{ $booking->start_date->format('d/m/Y') }} → {{ $booking->end_date->format('d/m/Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('properties.index') }}" class="text-sm text-primary hover:underline mt-2 inline-block">{{ __('Voir toutes les propriétés') }}</a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
