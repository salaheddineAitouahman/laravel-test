<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nos propriétés') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($properties->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                    {{ __('Aucune propriété disponible pour le moment.') }}
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
