<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Catalog\Enums\ProductFlag;

class AddExtraFeildsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string("preparation_time")->nullable()->after('product_flag');
            $table->string("requirements")->nullable()->after('preparation_time');
            $table->string("duration_of_stay")->nullable()->after('requirements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(["preparation_time", "requirements", "duration_of_stay"]);
        });
    }
}
