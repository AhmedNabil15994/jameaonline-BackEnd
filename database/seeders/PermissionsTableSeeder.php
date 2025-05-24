<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('permissions')->delete();

        DB::table('permissions')->insert(array(
            0 =>
            array(
                'id' => 4,
                'name' => 'dashboard_access',
                'display_name' => 'access',
                'created_at' => '2020-01-08 09:05:30',
                'updated_at' => '2021-09-05 18:35:35',
                'description' => '{"ar": "صلاحية المرور للوحة التحكم", "en": "Dashboard Access"}',
            ),
            1 =>
            array(
                'id' => 14,
                'name' => 'show_roles',
                'display_name' => 'roles',
                'created_at' => '2020-01-08 16:33:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            2 =>
            array(
                'id' => 15,
                'name' => 'add_roles',
                'display_name' => 'roles',
                'created_at' => '2020-01-08 16:33:11',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            3 =>
            array(
                'id' => 16,
                'name' => 'edit_roles',
                'display_name' => 'roles',
                'created_at' => '2020-01-08 16:33:16',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            4 =>
            array(
                'id' => 17,
                'name' => 'delete_roles',
                'display_name' => 'roles',
                'created_at' => '2020-01-08 16:33:21',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            5 =>
            array(
                'id' => 18,
                'name' => 'show_users',
                'display_name' => 'users',
                'created_at' => '2020-01-09 09:21:56',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            6 =>
            array(
                'id' => 19,
                'name' => 'add_users',
                'display_name' => 'users',
                'created_at' => '2020-01-09 09:22:11',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            7 =>
            array(
                'id' => 20,
                'name' => 'edit_users',
                'display_name' => 'users',
                'created_at' => '2020-01-09 09:22:24',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            8 =>
            array(
                'id' => 21,
                'name' => 'delete_users',
                'display_name' => 'users',
                'created_at' => '2020-01-09 09:22:39',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            9 =>
            array(
                'id' => 22,
                'name' => 'show_admins',
                'display_name' => 'employees',
                'created_at' => '2020-01-09 11:17:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            10 =>
            array(
                'id' => 23,
                'name' => 'add_admins',
                'display_name' => 'employees',
                'created_at' => '2020-01-09 11:17:42',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            11 =>
            array(
                'id' => 24,
                'name' => 'edit_admins',
                'display_name' => 'employees',
                'created_at' => '2020-01-09 11:18:00',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            12 =>
            array(
                'id' => 25,
                'name' => 'delete_admins',
                'display_name' => 'employees',
                'created_at' => '2020-01-09 11:18:16',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            13 =>
            array(
                'id' => 26,
                'name' => 'show_pages',
                'display_name' => 'pages',
                'created_at' => '2020-01-09 15:55:07',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            14 =>
            array(
                'id' => 27,
                'name' => 'add_pages',
                'display_name' => 'pages',
                'created_at' => '2020-01-09 15:55:26',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            15 =>
            array(
                'id' => 28,
                'name' => 'edit_pages',
                'display_name' => 'pages',
                'created_at' => '2020-01-09 15:55:45',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            16 =>
            array(
                'id' => 29,
                'name' => 'delete_pages',
                'display_name' => 'pages',
                'created_at' => '2020-01-09 15:56:05',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            17 =>
            array(
                'id' => 30,
                'name' => 'seller_access',
                'display_name' => 'access',
                'created_at' => '2020-01-13 10:38:53',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "الوصول للوحة تحكم البائعين", "en": "Access for sellers dashboard"}',
            ),
            18 =>
            array(
                'id' => 31,
                'name' => 'show_sellers',
                'display_name' => 'sellers',
                'created_at' => '2020-01-13 11:04:44',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            19 =>
            array(
                'id' => 32,
                'name' => 'add_sellers',
                'display_name' => 'sellers',
                'created_at' => '2020-01-13 11:05:03',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            20 =>
            array(
                'id' => 33,
                'name' => 'edit_sellers',
                'display_name' => 'sellers',
                'created_at' => '2020-01-13 11:05:22',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            21 =>
            array(
                'id' => 34,
                'name' => 'delete_sellers',
                'display_name' => 'sellers',
                'created_at' => '2020-01-13 11:06:09',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            22 =>
            array(
                'id' => 36,
                'name' => 'show_vendors',
                'display_name' => 'vendors',
                'created_at' => '2020-01-14 09:14:45',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            23 =>
            array(
                'id' => 37,
                'name' => 'add_vendors',
                'display_name' => 'vendors',
                'created_at' => '2020-01-14 09:15:05',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            24 =>
            array(
                'id' => 38,
                'name' => 'edit_vendors',
                'display_name' => 'vendors',
                'created_at' => '2020-01-14 09:15:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            25 =>
            array(
                'id' => 39,
                'name' => 'delete_vendors',
                'display_name' => 'vendors',
                'created_at' => '2020-01-14 09:15:43',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            26 =>
            array(
                'id' => 40,
                'name' => 'show_sections',
                'display_name' => 'sections',
                'created_at' => '2020-01-14 09:17:49',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            27 =>
            array(
                'id' => 41,
                'name' => 'add_sections',
                'display_name' => 'sections',
                'created_at' => '2020-01-14 09:18:07',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            28 =>
            array(
                'id' => 42,
                'name' => 'edit_sections',
                'display_name' => 'sections',
                'created_at' => '2020-01-14 09:18:26',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            29 =>
            array(
                'id' => 43,
                'name' => 'delete_sections',
                'display_name' => 'sections',
                'created_at' => '2020-01-14 09:18:54',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            30 =>
            array(
                'id' => 44,
                'name' => 'show_payments',
                'display_name' => 'payments',
                'created_at' => '2020-01-14 09:19:08',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            31 =>
            array(
                'id' => 45,
                'name' => 'add_payments',
                'display_name' => 'payments',
                'created_at' => '2020-01-14 09:19:13',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            32 =>
            array(
                'id' => 46,
                'name' => 'edit_payments',
                'display_name' => 'payments',
                'created_at' => '2020-01-14 09:19:17',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            33 =>
            array(
                'id' => 47,
                'name' => 'delete_payments',
                'display_name' => 'payments',
                'created_at' => '2020-01-14 09:19:22',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            34 =>
            array(
                'id' => 48,
                'name' => 'show_packages',
                'display_name' => 'packages',
                'created_at' => '2020-01-15 11:18:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            35 =>
            array(
                'id' => 49,
                'name' => 'add_packages',
                'display_name' => 'packages',
                'created_at' => '2020-01-15 11:18:25',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            36 =>
            array(
                'id' => 50,
                'name' => 'edit_packages',
                'display_name' => 'packages',
                'created_at' => '2020-01-15 11:18:39',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            37 =>
            array(
                'id' => 51,
                'name' => 'delete_packages',
                'display_name' => 'packages',
                'created_at' => '2020-01-15 11:18:55',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            38 =>
            array(
                'id' => 52,
                'name' => 'show_subscriptions',
                'display_name' => 'subscriptions',
                'created_at' => '2020-01-16 10:10:48',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            39 =>
            array(
                'id' => 53,
                'name' => 'add_subscriptions',
                'display_name' => 'subscriptions',
                'created_at' => '2020-01-16 10:11:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            40 =>
            array(
                'id' => 54,
                'name' => 'edit_subscriptions',
                'display_name' => 'subscriptions',
                'created_at' => '2020-01-16 10:11:15',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            41 =>
            array(
                'id' => 55,
                'name' => 'delete_subscriptions',
                'display_name' => 'subscriptions',
                'created_at' => '2020-01-16 10:11:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            42 =>
            array(
                'id' => 56,
                'name' => 'show_countries',
                'display_name' => 'countries',
                'created_at' => '2020-01-21 06:25:41',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            43 =>
            array(
                'id' => 57,
                'name' => 'add_countries',
                'display_name' => 'countries',
                'created_at' => '2020-01-21 06:25:54',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            44 =>
            array(
                'id' => 58,
                'name' => 'edit_countries',
                'display_name' => 'countries',
                'created_at' => '2020-01-21 06:26:09',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            45 =>
            array(
                'id' => 59,
                'name' => 'delete_countries',
                'display_name' => 'countries',
                'created_at' => '2020-01-21 06:26:26',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            46 =>
            array(
                'id' => 60,
                'name' => 'show_cities',
                'display_name' => 'cities',
                'created_at' => '2020-01-21 06:26:39',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            47 =>
            array(
                'id' => 61,
                'name' => 'add_cities',
                'display_name' => 'cities',
                'created_at' => '2020-01-21 06:26:51',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            48 =>
            array(
                'id' => 62,
                'name' => 'edit_cities',
                'display_name' => 'cities',
                'created_at' => '2020-01-21 06:27:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            49 =>
            array(
                'id' => 63,
                'name' => 'delete_cities',
                'display_name' => 'cities',
                'created_at' => '2020-01-21 06:27:17',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            50 =>
            array(
                'id' => 64,
                'name' => 'show_states',
                'display_name' => 'states',
                'created_at' => '2020-01-21 06:27:32',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            51 =>
            array(
                'id' => 65,
                'name' => 'add_states',
                'display_name' => 'states',
                'created_at' => '2020-01-21 06:27:43',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            52 =>
            array(
                'id' => 66,
                'name' => 'edit_states',
                'display_name' => 'states',
                'created_at' => '2020-01-21 06:35:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            53 =>
            array(
                'id' => 67,
                'name' => 'delete_states',
                'display_name' => 'states',
                'created_at' => '2020-01-21 06:35:19',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            54 =>
            array(
                'id' => 68,
                'name' => 'show_brands',
                'display_name' => 'brands',
                'created_at' => '2020-01-21 11:35:16',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            55 =>
            array(
                'id' => 69,
                'name' => 'add_brands',
                'display_name' => 'brands',
                'created_at' => '2020-01-21 11:36:35',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            56 =>
            array(
                'id' => 70,
                'name' => 'edit_brands',
                'display_name' => 'brands',
                'created_at' => '2020-01-21 11:36:46',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            57 =>
            array(
                'id' => 71,
                'name' => 'delete_brands',
                'display_name' => 'brands',
                'created_at' => '2020-01-21 11:37:08',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            58 =>
            array(
                'id' => 72,
                'name' => 'show_categories',
                'display_name' => 'categories',
                'created_at' => '2020-01-21 13:22:21',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            59 =>
            array(
                'id' => 73,
                'name' => 'add_categories',
                'display_name' => 'categories',
                'created_at' => '2020-01-21 13:22:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            60 =>
            array(
                'id' => 74,
                'name' => 'edit_categories',
                'display_name' => 'categories',
                'created_at' => '2020-01-21 13:22:39',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            61 =>
            array(
                'id' => 75,
                'name' => 'delete_categories',
                'display_name' => 'categories',
                'created_at' => '2020-01-21 13:22:49',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            62 =>
            array(
                'id' => 76,
                'name' => 'show_products',
                'display_name' => 'products',
                'created_at' => '2020-01-23 07:04:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            63 =>
            array(
                'id' => 77,
                'name' => 'add_products',
                'display_name' => 'products',
                'created_at' => '2020-01-23 07:04:46',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            64 =>
            array(
                'id' => 78,
                'name' => 'edit_products',
                'display_name' => 'products',
                'created_at' => '2020-01-23 07:04:57',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            65 =>
            array(
                'id' => 79,
                'name' => 'delete_products',
                'display_name' => 'products',
                'created_at' => '2020-01-23 07:05:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            66 =>
            array(
                'id' => 80,
                'name' => 'add_order_statuses',
                'display_name' => 'order_statuses',
                'created_at' => '2020-02-12 07:43:55',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            67 =>
            array(
                'id' => 81,
                'name' => 'edit_order_statuses',
                'display_name' => 'order_statuses',
                'created_at' => '2020-02-12 07:44:05',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            68 =>
            array(
                'id' => 82,
                'name' => 'delete_order_statuses',
                'display_name' => 'order_statuses',
                'created_at' => '2020-02-12 07:44:12',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            69 =>
            array(
                'id' => 83,
                'name' => 'show_order_statuses',
                'display_name' => 'order_statuses',
                'created_at' => '2020-02-12 07:44:19',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            70 =>
            array(
                'id' => 84,
                'name' => 'show_orders',
                'display_name' => 'orders',
                'created_at' => '2020-02-15 16:16:17',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            71 =>
            array(
                'id' => 85,
                'name' => 'add_orders',
                'display_name' => 'orders',
                'created_at' => '2020-02-15 16:16:23',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            72 =>
            array(
                'id' => 86,
                'name' => 'edit_orders',
                'display_name' => 'orders',
                'created_at' => '2020-02-15 16:16:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            73 =>
            array(
                'id' => 87,
                'name' => 'delete_orders',
                'display_name' => 'orders',
                'created_at' => '2020-02-15 16:16:49',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            74 =>
            array(
                'id' => 88,
                'name' => 'show_delivery_charges',
                'display_name' => 'delivery_charges',
                'created_at' => '2020-02-17 08:56:33',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            75 =>
            array(
                'id' => 89,
                'name' => 'add_delivery_charges',
                'display_name' => 'delivery_charges',
                'created_at' => '2020-02-17 08:56:47',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            76 =>
            array(
                'id' => 90,
                'name' => 'edit_delivery_charges',
                'display_name' => 'delivery_charges',
                'created_at' => '2020-02-17 08:56:56',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            77 =>
            array(
                'id' => 91,
                'name' => 'delete_delivery_charges',
                'display_name' => 'delivery_charges',
                'created_at' => '2020-02-17 08:57:07',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            78 =>
            array(
                'id' => 92,
                'name' => 'show_advertising',
                'display_name' => 'advertising',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            79 =>
            array(
                'id' => 93,
                'name' => 'add_advertising',
                'display_name' => 'advertising',
                'created_at' => '2020-02-19 12:34:33',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            80 =>
            array(
                'id' => 94,
                'name' => 'edit_advertising',
                'display_name' => 'advertising',
                'created_at' => '2020-02-19 12:34:44',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            81 =>
            array(
                'id' => 95,
                'name' => 'delete_advertising',
                'display_name' => 'advertising',
                'created_at' => '2020-02-19 12:34:55',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            82 =>
            array(
                'id' => 96,
                'name' => 'show_transactions',
                'display_name' => 'transactions',
                'created_at' => '2020-02-23 09:53:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            83 =>
            array(
                'id' => 97,
                'name' => 'show_options',
                'display_name' => 'options',
                'created_at' => '2020-02-23 11:55:35',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            84 =>
            array(
                'id' => 98,
                'name' => 'add_options',
                'display_name' => 'options',
                'created_at' => '2020-02-23 11:55:50',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            85 =>
            array(
                'id' => 99,
                'name' => 'edit_options',
                'display_name' => 'options',
                'created_at' => '2020-02-23 11:56:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            86 =>
            array(
                'id' => 100,
                'name' => 'delete_options',
                'display_name' => 'options',
                'created_at' => '2020-02-23 11:56:59',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            87 =>
            array(
                'id' => 101,
                'name' => 'driver_access',
                'display_name' => 'access',
                'created_at' => '2020-03-16 18:32:50',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "صلاحية السائقين", "en": "Driver Access Dashboard"}',
            ),
            88 =>
            array(
                'id' => 102,
                'name' => 'show_drivers',
                'display_name' => 'drivers',
                'created_at' => '2020-03-16 18:33:46',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            89 =>
            array(
                'id' => 103,
                'name' => 'add_drivers',
                'display_name' => 'drivers',
                'created_at' => '2020-03-16 18:34:00',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            90 =>
            array(
                'id' => 104,
                'name' => 'edit_drivers',
                'display_name' => 'drivers',
                'created_at' => '2020-03-16 18:34:14',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            91 =>
            array(
                'id' => 105,
                'name' => 'delete_drivers',
                'display_name' => 'drivers',
                'created_at' => '2020-03-16 18:34:25',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            92 =>
            array(
                'id' => 106,
                'name' => 'add_slider',
                'display_name' => 'slider',
                'created_at' => '2020-04-05 15:53:53',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            93 =>
            array(
                'id' => 107,
                'name' => 'edit_slider',
                'display_name' => 'slider',
                'created_at' => '2020-04-05 15:54:06',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            94 =>
            array(
                'id' => 108,
                'name' => 'delete_slider',
                'display_name' => 'slider',
                'created_at' => '2020-04-05 15:54:25',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            95 =>
            array(
                'id' => 109,
                'name' => 'show_slider',
                'display_name' => 'slider',
                'created_at' => '2020-04-05 15:54:48',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            96 =>
            array(
                'id' => 110,
                'name' => 'show_vendor_statuses',
                'display_name' => 'vendor_statuses',
                'created_at' => '2020-06-16 11:16:30',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            97 =>
            array(
                'id' => 111,
                'name' => 'add_vendor_statuses',
                'display_name' => 'vendor_statuses',
                'created_at' => '2020-06-16 11:16:39',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            98 =>
            array(
                'id' => 112,
                'name' => 'edit_vendor_statuses',
                'display_name' => 'vendor_statuses',
                'created_at' => '2020-06-16 11:16:49',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            99 =>
            array(
                'id' => 113,
                'name' => 'delete_vendor_statuses',
                'display_name' => 'vendor_statuses',
                'created_at' => '2020-06-16 11:17:04',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            100 =>
            array(
                'id' => 114,
                'name' => 'add_notifications',
                'display_name' => 'notifications',
                'created_at' => '2020-07-14 07:45:49',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            101 =>
            array(
                'id' => 115,
                'name' => 'show_coupon',
                'display_name' => 'coupons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            102 =>
            array(
                'id' => 116,
                'name' => 'add_coupon',
                'display_name' => 'coupons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            103 =>
            array(
                'id' => 117,
                'name' => 'edit_coupon',
                'display_name' => 'coupons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            104 =>
            array(
                'id' => 118,
                'name' => 'delete_coupon',
                'display_name' => 'coupons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:15',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            105 =>
            array(
                'id' => 119,
                'name' => 'show_gifts',
                'display_name' => 'gifts',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            106 =>
            array(
                'id' => 120,
                'name' => 'add_gifts',
                'display_name' => 'gifts',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            107 =>
            array(
                'id' => 121,
                'name' => 'edit_gifts',
                'display_name' => 'gifts',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            108 =>
            array(
                'id' => 122,
                'name' => 'delete_gifts',
                'display_name' => 'gifts',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            109 =>
            array(
                'id' => 123,
                'name' => 'show_cards',
                'display_name' => 'cards',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            110 =>
            array(
                'id' => 124,
                'name' => 'add_cards',
                'display_name' => 'cards',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            111 =>
            array(
                'id' => 125,
                'name' => 'edit_cards',
                'display_name' => 'cards',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            112 =>
            array(
                'id' => 126,
                'name' => 'delete_cards',
                'display_name' => 'cards',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            113 =>
            array(
                'id' => 127,
                'name' => 'show_wrapping_addons',
                'display_name' => 'wrapping_addons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            114 =>
            array(
                'id' => 128,
                'name' => 'add_wrapping_addons',
                'display_name' => 'wrapping_addons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            115 =>
            array(
                'id' => 129,
                'name' => 'edit_wrapping_addons',
                'display_name' => 'wrapping_addons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            116 =>
            array(
                'id' => 130,
                'name' => 'delete_wrapping_addons',
                'display_name' => 'wrapping_addons',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            117 =>
            array(
                'id' => 131,
                'name' => 'show_tags',
                'display_name' => 'tags',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            118 =>
            array(
                'id' => 132,
                'name' => 'add_tags',
                'display_name' => 'tags',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            119 =>
            array(
                'id' => 133,
                'name' => 'edit_tags',
                'display_name' => 'tags',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            120 =>
            array(
                'id' => 134,
                'name' => 'delete_tags',
                'display_name' => 'tags',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            121 =>
            array(
                'id' => 135,
                'name' => 'show_companies',
                'display_name' => 'companies',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            122 =>
            array(
                'id' => 136,
                'name' => 'add_companies',
                'display_name' => 'companies',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            123 =>
            array(
                'id' => 137,
                'name' => 'edit_companies',
                'display_name' => 'companies',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            124 =>
            array(
                'id' => 138,
                'name' => 'delete_companies',
                'display_name' => 'companies',
                'created_at' => '2020-02-19 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            125 =>
            array(
                'id' => 139,
                'name' => 'edit_products_price',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل سعر المنتج", "en": "Edit Products Price"}',
            ),
            126 =>
            array(
                'id' => 140,
                'name' => 'edit_products_qty',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل كمية المنتج", "en": "Edit Products Quantity"}',
            ),
            127 =>
            array(
                'id' => 141,
                'name' => 'edit_products_title',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل عنوان المنتج", "en": "Edit Products Title"}',
            ),
            128 =>
            array(
                'id' => 142,
                'name' => 'edit_products_description',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل وصف المنتج", "en": "Edit Products Description"}',
            ),
            129 =>
            array(
                'id' => 143,
                'name' => 'edit_products_image',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل صورة المنتج", "en": "Edit Products Image"}',
            ),
            130 =>
            array(
                'id' => 144,
                'name' => 'edit_products_gallery',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل صور المنتج", "en": "Edit Products Gallery"}',
            ),
            131 =>
            array(
                'id' => 145,
                'name' => 'edit_products_category',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل قسم المنتج", "en": "Edit Products Category"}',
            ),
            132 =>
            array(
                'id' => 146,
                'name' => 'pending_products_for_approval',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة منتج دون الموافقة", "en": "Add Product Without Approval"}',
            ),
            133 =>
            array(
                'id' => 147,
                'name' => 'review_products',
                'display_name' => 'products',
                'created_at' => '2020-01-23 05:04:57',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "مراجعة المنتجات", "en": "Review Products"}',
            ),
            134 =>
            array(
                'id' => 148,
                'name' => 'statistics',
                'display_name' => 'statistics',
                'created_at' => '2021-04-14 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض الاحصائيات", "en": "Show Statistics"}',
            ),
            135 =>
            array(
                'id' => 149,
                'name' => 'show_notifications',
                'display_name' => 'notifications',
                'created_at' => '2021-07-01 07:45:49',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            136 =>
            array(
                'id' => 150,
                'name' => 'delete_notifications',
                'display_name' => 'notifications',
                'created_at' => '2021-07-01 07:45:49',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            137 =>
            array(
                'id' => 151,
                'name' => 'show_search_keywords',
                'display_name' => 'search_keywords',
                'created_at' => '2021-07-13 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض", "en": "Show"}',
            ),
            138 =>
            array(
                'id' => 152,
                'name' => 'add_search_keywords',
                'display_name' => 'search_keywords',
                'created_at' => '2021-07-13 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "اضافة", "en": "Add"}',
            ),
            139 =>
            array(
                'id' => 153,
                'name' => 'edit_search_keywords',
                'display_name' => 'search_keywords',
                'created_at' => '2021-07-13 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "تعديل", "en": "Edit"}',
            ),
            140 =>
            array(
                'id' => 154,
                'name' => 'delete_search_keywords',
                'display_name' => 'search_keywords',
                'created_at' => '2021-07-13 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "حذف", "en": "Delete"}',
            ),
            141 =>
            array(
                'id' => 155,
                'name' => 'show_product_sale_reports',
                'display_name' => 'reports',
                'created_at' => '2021-07-27 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض تقارير المنتجات المباعة", "en": "Show Product Sale Reports"}',
            ),
            142 =>
            array(
                'id' => 156,
                'name' => 'show_order_sale_reports',
                'display_name' => 'reports',
                'created_at' => '2021-07-27 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض تقارير مبيعات الطلبات", "en": "Show Order Sale Reports "}',
            ),
            143 =>
            array(
                'id' => 157,
                'name' => 'show_vendors_reports',
                'display_name' => 'reports',
                'created_at' => '2021-07-27 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض تقارير المتاجر", "en": "Show Vendor Reports"}',
            ),
            144 =>
            array(
                'id' => 158,
                'name' => 'show_product_stock_reports',
                'display_name' => 'reports',
                'created_at' => '2021-07-27 12:34:24',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض تقارير مخزون المنتجات", "en": "Show Product Stock Reports"}',
            ),
            145 =>
            array(
                'id' => 159,
                'name' => 'show_all_orders',
                'display_name' => 'orders',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض جميع العمليات", "en": "Show All Orders"}',
            ),
            146 =>
            array(
                'id' => 160,
                'name' => 'show_order_details_tab',
                'display_name' => 'orders',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض نافذة تفاصيل الطلب", "en": "Show Order Details Tab"}',
            ),
            147 =>
            array(
                'id' => 161,
                'name' => 'show_order_change_status_tab',
                'display_name' => 'orders',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 18:36:16',
                'description' => '{"ar": "عرض نافذة تغيير حالة الطلب", "en": "Show Change Order Status Tab"}',
            ),
            148 =>
            array(
                'id' => 162,
                'name' => 'show_client_settings',
                'display_name' => 'client_settings',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض الإعدادات العامة", "en": "Show Client Settings update"}',
            ),
            149 =>
            array(
                'id' => 163,
                'name' => 'show_addon_categories',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض أقسام الإضافات", "en": "Show Addon Categories"}',
            ),
            150 =>
            array(
                'id' => 164,
                'name' => 'add_addon_categories',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "إضافة أقسام الإضافات", "en": "Add Addon Categories"}',
            ),
            151 =>
            array(
                'id' => 165,
                'name' => 'edit_addon_categories',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "تعديل أقسام الإضافات", "en": "Edit Addon Categories"}',
            ),
            152 =>
            array(
                'id' => 166,
                'name' => 'delete_addon_categories',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "حذف أقسام الإضافات", "en": "Delete Addon Categories"}',
            ),
            153 =>
            array(
                'id' => 167,
                'name' => 'show_addon_options',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض الإضافات", "en": "Show Addons"}',
            ),
            154 =>
            array(
                'id' => 168,
                'name' => 'add_addon_options',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "إضافة الإضافات", "en": "Add Addons"}',
            ),
            155 =>
            array(
                'id' => 169,
                'name' => 'edit_addon_options',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "تعديل الإضافات", "en": "Edit Addons"}',
            ),
            156 =>
            array(
                'id' => 170,
                'name' => 'delete_addon_options',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "حذف الإضافات", "en": "Delete Addons"}',
            ),
            157 =>
            array(
                'id' => 171,
                'name' => 'show_product_addons',
                'display_name' => 'addons',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض الإعدادات العامة", "en": "Show Product Addons"}',
            ),
            158 =>
            array(
                'id' => 172,
                'name' => 'show_vendor_categories',
                'display_name' => 'vendor_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض أقسام المتاجر", "en": "Show Vendors Categories"}',
            ),
            159 =>
            array(
                'id' => 173,
                'name' => 'add_vendor_categories',
                'display_name' => 'vendor_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "إضافة أقسام المتاجر", "en": "Add Vendors Categories"}',
            ),
            160 =>
            array(
                'id' => 174,
                'name' => 'edit_vendor_categories',
                'display_name' => 'vendor_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "تعديل أقسام المتاجر", "en": "Edit Vendors Categories"}',
            ),
            161 =>
            array(
                'id' => 175,
                'name' => 'delete_vendor_categories',
                'display_name' => 'vendor_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "حذف أقسام المتاجر", "en": "Delete Vendors Categories"}',
            ),
            162 =>
            array(
                'id' => 176,
                'name' => 'show_home_categories',
                'display_name' => 'home_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض أقسام الصفحة الرئيسية", "en": "Show Home Categories"}',
            ),
            163 =>
            array(
                'id' => 177,
                'name' => 'add_home_categories',
                'display_name' => 'home_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "إضافة أقسام الصفحة الرئيسية", "en": "Add Home Categories"}',
            ),
            164 =>
            array(
                'id' => 178,
                'name' => 'edit_home_categories',
                'display_name' => 'home_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "تعديل أقسام الصفحة الرئيسية", "en": "Edit Home Categories"}',
            ),
            165 =>
            array(
                'id' => 179,
                'name' => 'delete_home_categories',
                'display_name' => 'home_categories',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "حذف أقسام الصفحة الرئيسية", "en": "Delete Home Categories"}',
            ),
            166 =>
            array(
                'id' => 180,
                'name' => 'show_vendor_requests',
                'display_name' => 'vendor_requests',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "عرض طلبات التسجيل", "en": "Show Vendor Requests"}',
            ),
            167 =>
            array(
                'id' => 181,
                'name' => 'delete_vendor_requests',
                'display_name' => 'vendor_requests',
                'created_at' => '2021-07-27 16:16:17',
                'updated_at' => '2021-09-05 20:52:11',
                'description' => '{"ar": "حذف طلبات التسجيل", "en": "Delete Vendor Requests"}',
            ),
        ));
    }
}
