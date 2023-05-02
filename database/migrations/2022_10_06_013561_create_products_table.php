<?php

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->integer('price')->default(0);
            $table->text('description')->nullable();
            $table->text('description_html')->nullable();
            $table->integer('stock_local')->default(0);
            $table->integer('stock_local_min')->default(0);
            $table->integer('stock_virtual')->default(0);
            $table->bigInteger('barcode')->unique()->nullable();
            $table->integer('ncm')->nullable();
            $table->float('weight')->default(0);
            $table->float('height')->default(0);
            $table->float('width')->default(0);
            $table->float('length')->default(0);
            $table->integer('availability')->default(0);
            $table->text('keywords')->nullable();
            $table->integer('status')->default(ProductStatusEnum::Active);
            $table->string('brand')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
