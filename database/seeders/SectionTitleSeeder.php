<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'why_choose_sub_title', 'value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.'],
            ['key' => 'why_choose_top_title', 'value' => 'why choose us'],
            ['key' => 'why_choose_main_title', 'value' => 'why choose us'],
            ['key' => 'menu_top_title', 'value' => 'food Menu'],
            ['key' => 'menu_main_title', 'value' => 'Our Popular Delicious Foods'],
            ['key' => 'menu_sub_title', 'value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.'],
            ['key' => 'daily_offer_top_title', 'value' => 'Daily offer'],
            ['key' => 'daily_offer_main_title', 'value' => 'Up to 75% off for this day'],
            ['key' => 'daily_offer_sub_title', 'value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.'],
            ['key' => 'chef_top_title', 'value' => 'our team'],
            ['key' => 'chef_main_title', 'value' => 'meet our expert chefs'],
            ['key' => 'chef_sub_title', 'value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.'],
            ['key' => 'testimonial_top_title', 'value' => 'testimonial'],
            ['key' => 'testimonial_main_title', 'value' => 'our customar feedbacks'],
            ['key' => 'testimonial_sub_title', 'value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.'],
            ['key' => 'blog_top_title', 'value' => 'news & blogs'],
            ['key' => 'blog_main_title', 'value' => 'our latest foods blogs'],
            ['key' => 'blog_sub_title', 'value' => null],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('section_titles')->truncate();
        DB::table('section_titles')->insert($data);
    }
}
