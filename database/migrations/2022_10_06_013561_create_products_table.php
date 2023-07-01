<?php

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Tenant;

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
            $table->foreignIdFor(Tenant::class)->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('model', 50)->nullable()->unique();
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
            $table->integer('status')->default(ProductStatusEnum::Active->value);
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
