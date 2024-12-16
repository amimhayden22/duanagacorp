<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Buat Permissions dengan Camel Case
         $permissions = [
            'Read Category',
            'Create Category',
            'Update Category',
            'Create Material',
            'Read Material',
            'Update Material',
            'Create User',
            'Read User',
            'Update User',
            'Role And Permission',
        ];

        // Menambahkan Permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);

        // Tambahkan Permissions ke Admin
        $adminRole->givePermissionTo($permissions);

        // Tambahkan Permissions khusus untuk User (misalnya hanya Read dan Update)
        $userRole->givePermissionTo([
            'Read Category',
            'Read Material',
        ]);

        // Buat Admin User
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@duanagacorp.co.id',
            'password' => Hash::make('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $admin->assignRole('Admin');

        // Buat Regular User
        $user = User::create([
            'name' => 'user',
            'email' => 'user@duanagacorp.co.id',
            'password' => Hash::make('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $user->assignRole('User');
    }
}
