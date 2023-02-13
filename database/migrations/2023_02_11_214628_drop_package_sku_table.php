<?php

declare(strict_types=1);

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
    public function up(): void
    {
        Schema::dropIfExists('package_sku');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::create('package_sku', function (Blueprint $table) {
            $table->primary(['package_id', 'sku_id']);
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sku_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->timestamps();
        });
    }
};
