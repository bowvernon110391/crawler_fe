<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('shop_id');
            $table->string('name');
            $table->string('url');
            // some are optionals
            $table->string('domain')->nullable();
            $table->string('kota');
            $table->mediumText('alamat');

            
            $table->string('kode_pos')->nullable();
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();

            $table->dateTime('last_active')->nullable();
            $table->dateTime('registered_at')->nullable();

            $table->string('marketplace');

            $table->timestamps();


            // constraints?
            $table->unique(['shop_id', 'marketplace']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
