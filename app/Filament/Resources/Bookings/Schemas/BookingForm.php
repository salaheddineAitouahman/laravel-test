<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('property_id')
                    ->relationship('property', 'name')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
            ]);
    }
}
