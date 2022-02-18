<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('username')->index();
            $table->string('group');
            $table->string('status');
            $table->string('last_token')->index();
            $table->string('nama');
            $table->string('nip')->nullable()->index();
            $table->string('kantor')->nullable();
            $table->string('kantor_id')->nullable();
            $table->string('kantor_level')->nullable();
            $table->string('kode_eselon2')->nullable();
            $table->string('eselon2')->nullable();
            $table->string('kode_eselon3')->nullable();
            $table->string('eselon3')->nullable();

            // add role, nullable? nope. must be empty
            $table->string('role_string')->default('');

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
        Schema::dropIfExists('users');
    }
}
