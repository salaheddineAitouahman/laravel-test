<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255)
                    ->helperText('Laisser vide à l\'édition pour ne pas modifier le mot de passe.'),
                Select::make('roles')
                    ->relationship('roles', 'label')
                    ->multiple()
                    ->preload()
                    ->label('Rôles')
                    ->helperText('Le rôle « Administrateur » donne accès au panneau Filament.'),
            ]);
    }
}
