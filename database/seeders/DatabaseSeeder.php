<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UserSeeder::class);
        $this->call(WhyChooseUsTitleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PaymentGatewaySettingSeeder::class);
        $this->call(SectionTitleSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}

// php artisan db:seed --class=CategorySeeder

// php artisan db:seed
