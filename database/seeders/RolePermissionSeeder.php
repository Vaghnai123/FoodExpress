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
            'sliders' => ['manage sliders'],
            'daily_offers' => ['manage daily offers'],
            'products' => ['view products', 'create products', 'edit products', 'delete products'],
            'categories' => ['view categories', 'create categories', 'edit categories', 'delete categories'],
            'orders' => ['view orders'],
            'ecommerce' => ['manage ecommerce'],
            'delivery_areas' => ['view delivery areas', 'create delivery areas', 'edit delivery areas', 'delete delivery areas'],
            'coupons' => ['view coupons', 'create coupons', 'edit coupons', 'delete coupons'],
            'payment_settings' => ['view payment settings'],
            'reservations' => ['view reservations'],
            'chat' => ['access chat'],
            'blogs' => ['view blogs', 'create blogs', 'edit blogs', 'delete blogs'],
            'settings' => ['manage settings'],
            'admin_management' => ['view admins', 'create admins', 'edit admins', 'delete admins'],
            'roles' => ['view roles', 'create roles', 'edit roles', 'delete roles'],
            'sections' => ['manage sections'],
            'pages' => ['manage pages'],
            'permissions' => ['manage permissions'],
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
            'view dashboard',
            'view products',
            'view categories',
            'view orders',
            'manage settings'
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
