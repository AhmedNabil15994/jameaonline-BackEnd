<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sections')->delete();

        \DB::table('sections')->insert(array(
            0 =>
            array(
                'id' => 1,
                'flag' => 'restaurant',
                'seo_keywords' => '{"ar": null, "en": null}',
                'seo_description' => '{"ar": null, "en": null}',
                'slug' => '{"ar": "mataeim", "en": "restaurants"}',
                'title' => '{"ar": "مطاعم", "en": "Restaurants"}',
                'description' => '{"ar": "<p>مطاعم</p>", "en": "<p>Restaurants</p>"}',
                'status' => 1,
                'image' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-08-12 12:58:20',
                'updated_at' => '2021-09-06 21:09:55',
            ),
            1 =>
            array(
                'id' => 2,
                'flag' => 'service',
                'seo_keywords' => '{"ar": null, "en": null}',
                'seo_description' => '{"ar": null, "en": null}',
                'slug' => '{"ar": "khadamat", "en": "services"}',
                'title' => '{"ar": "خدمات", "en": "Services"}',
                'description' => '{"ar": "<p>خدمات</p>", "en": "<p>Services</p>"}',
                'status' => 1,
                'image' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-08-16 05:57:27',
                'updated_at' => '2021-09-06 21:15:18',
            ),
            2 =>
            array(
                'id' => 3,
                'flag' => 'shop',
                'seo_keywords' => '{"ar": null, "en": null}',
                'seo_description' => '{"ar": null, "en": null}',
                'slug' => '{"ar": "mahlat", "en": "shops"}',
                'title' => '{"ar": "محلات", "en": "Shops"}',
                'description' => '{"ar": "<p>محلات</p>", "en": "<p>Shops</p>"}',
                'status' => 1,
                'image' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-08-16 05:57:27',
                'updated_at' => '2021-09-06 21:15:18',
            ),
        ));
    }
}
