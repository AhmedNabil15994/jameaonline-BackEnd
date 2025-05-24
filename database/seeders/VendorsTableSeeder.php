<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vendors')->delete();

        \DB::table('vendors')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'seo_keywords' => '{"ar": "متجر تيك لوك", "en": "Takelook Vendor"}',
                    'seo_description' => '{"ar": "متجر تيك لوك", "en": "Takelook Vendor"}',
                    'slug' => '{"ar": "takelook-matger", "en": "takelook-vendor"}',
                    'title' => '{"ar": "متجر تيك لوك", "en": "Takelook Vendor"}',
                    'description' => '{"ar": "<p>متجر تيك لوك</p>", "en": "<p>Takelook Vendor</p>"}',
                    'image' => 'storage/photos/shares/vendors/default.jpg',
                    'sorting' => 0,
                    'status' => 1,
                    'vendor_email' => 'takelook_vendor@example.com',
                    'vendor_status_id' => 1,
                    'deleted_at' => NULL,
                    'created_at' => '2020-08-14 11:13:48',
                    'updated_at' => '2021-09-07 17:29:14',
                ),
        ));


    }
}
