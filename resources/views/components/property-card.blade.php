@props(['property'])

<a href="{{ route('properties.show', $property) }}" class="block group">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:border-primary hover:shadow-md transition duration-150">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary">{{ $property->name }}</h3>
            <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ Str::limit($property->description, 100) }}</p>
            <p class="mt-3 text-primary font-semibold">{{ number_format($property->price_per_night, 0, ',', ' ') }} € <span class="text-gray-500 font-normal text-sm">/ nuit</span></p>
        </div>
    </div>
</a>
