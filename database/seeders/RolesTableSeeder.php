<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'admins',
                'created_at' => '2020-01-08 11:31:55',
                'updated_at' => '2020-01-13 10:41:09',
                'display_name' => NULL,
                'description' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'vendors',
                'created_at' => '2020-01-13 10:40:10',
                'updated_at' => '2020-01-13 10:40:10',
                'display_name' => NULL,
                'description' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'drivers',
                'created_at' => '2020-03-16 18:36:35',
                'updated_at' => '2020-03-16 18:36:35',
                'display_name' => NULL,
                'description' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'dsadsa',
                'created_at' => '2020-08-14 10:57:52',
                'updated_at' => '2021-09-05 21:07:16',
                'display_name' => '{"ar": "asdsasad", "en": "dsadsa"}',
                'description' => '{"en": null}',
            ),
        ));
        
        
    }
}