<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Identifiant technique (ex: admin, utilisateur, moderateur).'),
                TextInput::make('label')
                    ->maxLength(255)
                    ->label('Libellé')
                    ->helperText('Nom affiché (ex: Administrateur, Utilisateur).'),
            ]);
    }
}
