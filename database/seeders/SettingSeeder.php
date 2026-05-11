<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'site_name', 'value' => 'Food Express'],
            ['key' => 'site_email', 'value' => 'Vaghanijil1749@gmail.com'],
            ['key' => 'site_phone', 'value' => '+91 2839402043'],
            ['key' => 'site_default_currency', 'value' => 'USD'],
            ['key' => 'site_currency_icon', 'value' => '$'],
            ['key' => 'site_currency_icon_position', 'value' => 'right'],
            ['key' => 'pusher_app_id', 'value' => '2150056'],
            ['key' => 'pusher_key', 'value' => '1a73b022848ee0f43311'],
            ['key' => 'pusher_secret', 'value' => '1fd128f4575a803afe2b'],
            ['key' => 'pusher_cluster', 'value' => 'mt1'],
            ['key' => 'site_address', 'value' => 'Krishna Arcade Near Tulshi Residency'],
            ['key' => 'mail_driver', 'value' => 'smtp'],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com'],
            ['key' => 'mail_port', 'value' => '465'],
            ['key' => 'mail_username', 'value' => 'vaghanijil8044@gmail.com'],
            ['key' => 'mail_password', 'value' => 'blftyhohoitvxduc'],
            ['key' => 'mail_encryption', 'value' => 'ssl'],
            ['key' => 'mail_from_address', 'value' => 'vaghanijil8044@gmail.com'],
            ['key' => 'mail_receive_address', 'value' => 'vaghanijil8044@gmail.com'],
            ['key' => 'logo', 'value' => '/uploads/media_6a000b2cb419c.png'],
            ['key' => 'footer_logo', 'value' => '/uploads/media_6a000b2cba588.png'],
            ['key' => 'favicon', 'value' => '/uploads/media_6a00112f2c43e.png'],
            ['key' => 'breadcrumb', 'value' => '/uploads/media_6a001301b6c4a.jpg'],
            ['key' => 'seo_title', 'value' => 'FoodExpress'],
            ['key' => 'seo_description', 'value' => 'Food Express is a Food Delivery Website'],
            ['key' => 'seo_keywords', 'value' => 'FoodExpress'],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('settings')->truncate();
        DB::table('settings')->insert($data);
    }
}
