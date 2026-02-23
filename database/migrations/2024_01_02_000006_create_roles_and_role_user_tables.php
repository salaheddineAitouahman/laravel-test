<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // ex: admin, utilisateur
            $table->string('label')->nullable(); // ex: Administrateur, Utilisateur
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
        });

        // Rôles par défaut
        DB::table('roles')->insert([
            ['name' => 'admin', 'label' => 'Administrateur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'utilisateur', 'label' => 'Utilisateur', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Migrer les anciens is_admin vers le rôle admin
        if (Schema::hasColumn('users', 'is_admin')) {
            $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
            $adminUserIds = DB::table('users')->where('is_admin', true)->pluck('id');
            foreach ($adminUserIds as $userId) {
                DB::table('role_user')->insertOrIgnore([
                    'user_id' => $userId,
                    'role_id' => $adminRoleId,
                ]);
            }
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });

        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        if ($adminRoleId) {
            $adminUserIds = DB::table('role_user')->where('role_id', $adminRoleId)->pluck('user_id');
            DB::table('users')->whereIn('id', $adminUserIds)->update(['is_admin' => true]);
        }

        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
