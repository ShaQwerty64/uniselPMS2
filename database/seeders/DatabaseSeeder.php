<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'modify admin']);
        Permission::create(['name' => 'modify viewer']);
        Permission::create(['name' => 'modify projects']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'view projects']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('modify admin');
        $role1->givePermissionTo('modify viewer');
        $role1->givePermissionTo('modify projects');
        $role1->givePermissionTo('view projects');

        $role2 = Role::create(['name' => 'projMan']);
        $role2->givePermissionTo('edit projects');

        $role3 = Role::create(['name' => 'topMan']);
        $role3->givePermissionTo('view projects');

        $role4 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example User',
        //     'email' => 'test@example.com',
        // ]);
        // $user->assignRole($role1);
    }
}
