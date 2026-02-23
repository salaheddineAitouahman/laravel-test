<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getRules(): array
    {
        return [
            'data.password' => ['required', 'string', 'min:8'],
        ];
    }

    protected function afterCreate(): void
    {
        $this->record->roles()->sync($this->form->getState()['roles'] ?? []);
    }
}
