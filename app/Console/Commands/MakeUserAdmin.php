<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin {email : L\'adresse email de l\'utilisateur}';

    protected $description = 'Donne le rôle administrateur à un utilisateur (accès Filament)';

    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("Aucun utilisateur trouvé avec l'email : {$email}");
            return self::FAILURE;
        }

        $adminRole = Role::where('name', 'admin')->first();
        if (! $adminRole) {
            $this->error('Le rôle "admin" n\'existe pas. Exécutez les migrations.');
            return self::FAILURE;
        }

        if ($user->hasRole('admin')) {
            $this->info("L'utilisateur {$email} a déjà le rôle administrateur.");
            return self::SUCCESS;
        }

        $user->roles()->attach($adminRole->id);
        $this->info("L'utilisateur {$email} a maintenant le rôle administrateur.");

        return self::SUCCESS;
    }
}
