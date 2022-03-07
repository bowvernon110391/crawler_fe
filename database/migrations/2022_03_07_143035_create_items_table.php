<?php

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // must make some nullable too
            $table->bigInteger('item_id');
            $table->string('name');
            $table->string('url');
            $table->string('image_url');

            // optionals
            $table->decimal('rating')->nullable();
            $table->decimal('rating_avg')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('view_count')->nullable();
            $table->integer('wishlist_count')->nullable();

            // relational
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Shop::class);

            // constraints
            // shopid + itemid must be unique
            $table->unique(['item_id', 'shop_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
