<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard' => ['view dashboard'], 
            'products' => ['view products', 'create products', 'edit products', 'delete products'],
            'categories' => ['view categories', 'create categories', 'edit categories', 'delete categories'],
            'orders' => ['view orders', 'update orders', 'delete orders'],
            'coupons' => ['view coupons', 'create coupons', 'edit coupons', 'delete coupons'],
            'blogs' => ['view blogs', 'create blogs', 'edit blogs', 'delete blogs'],
            'reservations' => ['view reservations', 'manage reservations'],
            'settings' => ['manage settings'],
            'admin_management' => ['view admins', 'create admins', 'edit admins', 'delete admins'],
            'roles' => ['view roles', 'create roles', 'edit roles', 'delete roles'],
            'chat' => ['access chat'],
            'sliders' => ['manage sliders'],
            'daily_offers' => ['manage daily offers'],
            'ecommerce' => ['manage ecommerce'],
            'sections' => ['manage sections'],
            'pages' => ['manage pages'],
        ];

        foreach ($permissions as $group => $perms) {
            foreach ($perms as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web', 'group_name' => $group]);
            }
        }


        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);

        $adminRole->givePermissionTo([
            'view dashboard', 'view products', 'view categories', 'view orders', 'manage settings'
        ]);

        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@example.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $superAdmin->assignRole('Super Admin');
    }
}
