<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('price');
            $table->integer('quantity');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('sku_id');
            $table->foreign('package_id')->references('id')->on('skus');
            $table->foreign('sku_id')->references('id')->on('skus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('name');
            $table->float('price');
            $table->dropForeign('packages_package_id_foreign');
            $table->dropForeign('packages_sku_id_foreign');
            $table->dropColumn('package_id');
            $table->dropColumn('sku_id');
            $table->dropColumn('quantity');
        });
    }
};
