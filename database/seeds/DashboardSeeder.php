<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\PagesTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\StatesTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\PermissionRoleTableSeeder;
use Database\Seeders\PackagesTableSeeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $this->insertSetting();
            $this->insertCountries();
            $this->insertOption();
            $this->insertCities();
            $this->insertSates();
            $this->insertLtmTranslations();
            $this->inserPackages();
            $this->inserPyments();
            $this->insertSections();
            $this->inserPages();
            $this->insertRoleAndPermissions();
            $this->insertUsers();
            $this->insertVendor();
            $this->insertShippingCompany();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insert($string)
    {
        DB::statement($string);
    }

    public function insertSetting()
    {
        $data = "
        INSERT INTO `settings` (`id`, `key`, `value`, `locale`, `created_at`, `updated_at`) VALUES
        (1, 'locales', '[\"en\",\"ar\"]', NULL, NULL, NULL),
        (2, 'default_locale', 'ar', NULL, NULL, NULL),
        (3, 'app_name', '{\"en\":\"TakeLookApp\",\"ar\":\"TakeLookApp\"}', 'en', NULL, NULL),
        (4, 'app_name', '{\"en\":\"TakeLookApp\",\"ar\":\"TakeLookApp\"}', 'ar', NULL, NULL),
        (5, 'rtl_locales', '[\"ar\"]', NULL, NULL, NULL),
        (7, 'translate', '{\"app_name\":\"TakeLookApp\"}', NULL, NULL, NULL),
        (8, 'contact_us', '{\"email\":\"info@stg.takelookapp.com\",\"whatsapp\":\"0096550842421\"}', NULL, NULL, NULL),
        (9, 'social', '{\"facebook\":\"#\",\"twitter\":\"#\",\"instagram\":\"#\",\"linkedin\":\"#\",\"youtube\":\"#\",\"snapchat\":\"#\"}', NULL, NULL, NULL),
        (10, 'env', '{\"MAIL_DRIVER\":\"smtp\",\"MAIL_ENCRYPTION\":\"tls\",\"MAIL_HOST\":\"smtp.gmail.com\",\"MAIL_PORT\":\"587\",\"MAIL_FROM_ADDRESS\":\"info@stg.takelookapp.com\",\"MAIL_FROM_NAME\":\"Vendo-Website\",\"MAIL_USERNAME\":\"info@stg.takelookapp.com\",\"MAIL_PASSWORD\":\"amr147147\"}', NULL, NULL, NULL),
        (11, 'default_shipping', NULL, NULL, NULL, NULL),
        (14, 'other', '{\"privacy_policy\":\"1\",\"terms\":\"1\",\"shipping_company\":\"1\",\"about_us\":\"1\",\"force_update\":\"0\",\"is_multi_vendors\":\"1\",\"select_shipping_provider\":\"shipping_company\"}', NULL, NULL, NULL),
        (15, 'logo', 'storage/photos/shares/logo/logo.png', NULL, NULL, NULL),
        (16, 'favicon', 'storage/photos/shares/favicon/favicon.png', NULL, NULL, NULL),
        (17, 'images', '{\"logo\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/photos\\/shares\\/logo\\/logo.png\",\"favicon\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/photos\\/shares\\/favicon\\/favicon.png\"}', NULL, NULL, NULL),
        (18, 'loogo', '/storage/photos/shares/5e300ffd16038.png', NULL, NULL, NULL),
        (20, 'default_vendor', '1', NULL, NULL, NULL),
        (21, 'app_name', '{\"en\":\"TakeLookApp\",\"ar\":\"TakeLookApp\"}', NULL, NULL, NULL),
        (22, 'app_description', '{\"en\":\"E-commerce App\",\"ar\":\"E-commerce App\"}', NULL, NULL, NULL),
        (23, 'white_logo', 'storage/photos/shares/logo/footer/logo.png', NULL, NULL, NULL),
        (24, 'payment_gateway', '{\"upayment\":{\"test_mode\":{\"MERCHANT_ID\":\"1201\",\"API_KEY\":\"jtest123\",\"USERNAME\":\"test\",\"PASSWORD\":\"test\",\"IBAN\":null},\"live_mode\":{\"MERCHANT_ID\":\"30281\",\"API_KEY\":\"87e98167ee7c515761b727519dd6863452e2e861\",\"USERNAME\":\"TakeLook\",\"PASSWORD\":\"0]T27w{hR4BB\",\"IBAN\":null},\"payment_mode\":\"test_mode\"}}', NULL, NULL, NULL),
        (25, 'countries', '[\"KW\"]', NULL, NULL, NULL);
        ";
        $this->insert($data);
    }

    public function insertCities()
    {
        $this->call(\Database\Seeders\CitiesTableSeeder::class);
    }

    public function insertCountries()
    {
        $this->call(\Database\Seeders\CountriesTableSeeder::class);
    }

    public function insertLtmTranslations()
    {
        $data = "
            INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`, `saved_value`, `is_deleted`, `was_used`, `source`, `is_auto_added`) VALUES
            (1, 0, 'ar', 'setting::dashboard', 'password.email.required', NULL, '2020-09-02 12:20:25', '2020-09-02 12:20:25', NULL, 0, 0, NULL, 0),
            (2, 0, 'ar', 'setting::dashboard', 'password.email.email', NULL, '2020-09-02 12:20:25', '2020-09-02 12:20:25', NULL, 0, 0, NULL, 0),
            (3, 0, 'ar', 'setting::dashboard', 'password.email.exists', NULL, '2020-09-02 12:20:25', '2020-09-02 12:20:25', NULL, 0, 0, NULL, 0);
        ";
        $this->insert($data);
    }

    public function inserPackages()
    {
        $this->call(\Database\Seeders\PackagesTableSeeder::class);
    }

    public function inserPages()
    {
        $this->call(PagesTableSeeder::class);
    }

    public function inserPyments()
    {
        $this->call(\Database\Seeders\PaymentsTableSeeder::class);
    }

    public function insertRoleAndPermissions()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
        ]);
    }


    public function insertUsers()
    {
        $data = "
            INSERT INTO `users` (`id`, `name`, `image`, `calling_code`, `mobile`, `country_id`, `email`, `email_verified_at`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, 'Super Admin', '/uploads/users/user.png', '965', '12345678', 1, 'admin@admin.com', NULL, '$2y$10\$ZZ92yXvy5ncN1tHUCTCF4.gpaZ2SHPGkwEZmzs0NXsm.JAU63gnWq', '$2y$10\$ZZ92yXvy5ncN1tHUCTCF4.gpaZ2SHPGkwEZmzs0NXsm.JAU63gnWq', NULL, '2019-12-26 07:14:17', '2020-06-30 10:43:06'),
            (38, 'admin', '/uploads/users/user.png', '965', '55060673', 1, 'admin@tocaan.com', NULL, '$2y$10\$rSITzhfx3qwbT6JBq5FrduHeM7hvY6Qco0.t5ylEUsNcBn1nlbrnW', NULL, NULL, '2020-07-01 08:09:55', '2020-07-08 04:06:40'),
            (41, 'admin', '/uploads/users/user.png', '965', '55060671', 1, 'admin@stg.takelookapp.com', NULL, '$2y$10$7gyRgmdBnaob4e1ocNa8dO.VrciAKrxXlMbplc4ag6TeTROmXroAa', NULL, NULL, '2020-08-14 10:58:36', '2020-08-14 10:58:36'),
            (42, 'Vendor Seller', '/uploads/users/user.png', '965', '55060676', 1, 'admin@vendor.com', NULL, '$2y$10\$wAmyuUVyU8DVSHGQHlEn2eVvNOfgAvr6vQk7RQ50VHnVirC3Y8XSe', NULL, NULL, '2020-08-14 11:05:33', '2020-08-14 11:05:33'),
            (43, 'editor', '/uploads/users/user.png', '965', '55060670', 1, 'editor@tocaan.com', NULL, '$2y$10\$jqEVtiy0Khcml.zzPNpL3uvIpXVT22nNlvZ9dORaHu9REbiJcdIdS', NULL, NULL, '2020-08-16 05:50:42', '2020-08-16 05:50:42');

        ";

        $this->insert($data);

        $data = '
        INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
        (1, 2),
        (38, 2),
        (42, 3),
        (41, 5),
        (43, 5);

        ';
        $this->insert($data);
    }

    public function insertVendor()
    {
        $this->call(\Database\Seeders\VendorStatusesTableSeeder::class);

        $this->call(\Database\Seeders\VendorsTableSeeder::class);

        $data = "
        INSERT INTO `vendor_sellers` (`id`, `vendor_id`, `seller_id`, `created_at`, `updated_at`) VALUES (NULL, '1', '42', NULL, NULL);

        ";
        $this->insert($data);

        $data = "
            INSERT INTO `subscriptions` (`id`, `original_price`, `total`, `start_at`, `end_at`, `status`, `send_expiration_at`, `package_id`, `vendor_id`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, '50', '120', '2020-09-01', '2030-09-30', '1', '2030-09-29 18:12:25', '3', '1', NULL, NULL, NULL);
        ";
        $this->insert($data);
    }

    public function insertSections()
    {
        $this->call(\Database\Seeders\SectionsTableSeeder::class);
    }

    public function insertSates()
    {
        $this->call(\Database\Seeders\StatesTableSeeder::class);
    }

    public function insertOption()
    {
        $this->call(\Database\Seeders\OptionsTableSeeder::class);
        $this->call(\Database\Seeders\OptionValuesTableSeeder::class);
    }

    public function insertShippingCompany()
    {
        $this->call(\Database\Seeders\CompaniesTableSeeder::class);
        $this->call(\Database\Seeders\CompanyAvailabilitiesTableSeeder::class);
    }
}
