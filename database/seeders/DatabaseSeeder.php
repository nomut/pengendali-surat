<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $abilities = config('permission.abilities');

        $this->createPermissions($abilities);

        $role = Role::create(['name' => 'administrator']);
        $role->syncPermissions($abilities);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role);
    }

    private function createPermissions($abilities) : void
    {
        foreach($abilities as $ability) {
            Permission::create(['name' => $ability]);
        }
    }
}
