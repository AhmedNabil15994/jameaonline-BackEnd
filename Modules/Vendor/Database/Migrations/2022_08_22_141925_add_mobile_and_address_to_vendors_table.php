<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileAndAddressToVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('calling_code', 10)->nullable()->after('section_id');
            $table->string('mobile', 30)->unique()->nullable()->after('calling_code');
            $table->string('whatsapp', 30)->nullable()->after('mobile');
            $table->json('address')->nullable()->after('whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['calling_code', 'mobile', 'address', 'whatsapp']);
        });
    }
}
