<?php

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Locked]
    public $propertyId;

    #[Validate('required|date|after_or_equal:today')]
    public $start_date = '';

    #[Validate('required|date|after:start_date')]
    public $end_date = '';

    public function mount($property)
    {
        $this->propertyId = $property->id;
    }

    public function getNights(): int
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        $start = \Carbon\Carbon::parse($this->start_date);
        $end = \Carbon\Carbon::parse($this->end_date);
        return $start->diffInDays($end);
    }

    public function getTotalPrice(): float
    {
        $property = \App\Models\Property::find($this->propertyId);
        if (!$property || $this->getNights() === 0) {
            return 0;
        }
        return $this->getNights() * (float) $property->price_per_night;
    }

    public function getProperty()
    {
        return \App\Models\Property::find($this->propertyId);
    }

    public function submit()
    {
        $this->validate();

        $property = $this->getProperty();
        if (!$property) {
            $this->addError('property', 'Propriété introuvable.');
            return;
        }

        $start = \Carbon\Carbon::parse($this->start_date);
        $end = \Carbon\Carbon::parse($this->end_date);

        $overlaps = Booking::where('property_id', $this->propertyId)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_date', '<=', $start)->where('end_date', '>=', $end);
                    });
            })
            ->exists();

        if ($overlaps) {
            $this->addError('dates', 'Ces dates ne sont pas disponibles pour cette propriété.');
            return;
        }

        Booking::create([
            'user_id' => auth()->id(),
            'property_id' => $this->propertyId,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->dispatch('booking-created');
        session()->flash('message', 'Réservation enregistrée avec succès.');
        $this->reset('start_date', 'end_date');
    }
};
?>

<div>
    @if (session('message'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-800 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Date d'arrivée</label>
                <input type="date" id="start_date" wire:model.blur="start_date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm"
                    min="{{ date('Y-m-d') }}">
                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Date de départ</label>
                <input type="date" id="end_date" wire:model.blur="end_date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm"
                    min="{{ $start_date ? \Carbon\Carbon::parse($start_date)->addDay()->format('Y-m-d') : date('Y-m-d') }}">
                @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @error('dates')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if($this->getNights() > 0)
            <p class="text-gray-700">
                <span class="font-medium">{{ $this->getNights() }}</span> nuit(s) —
                <span class="text-primary font-semibold">{{ number_format($this->getTotalPrice(), 0, ',', ' ') }} €</span> total
            </p>
        @endif

        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-900 focus:bg-blue-900 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
            Réserver
        </button>
    </form>
</div>
