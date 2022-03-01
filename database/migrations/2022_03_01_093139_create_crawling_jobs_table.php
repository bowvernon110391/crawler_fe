<?php

use App\Models\SSO\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawling_jobs', function (Blueprint $table) {
            $table->id();

            // name?
            $table->string('name');
            // keywords in one string
            $table->text('keyword_data');  // internal storage, will be converted as array on input/output
            // status
            // $table->enum('status', ['CREATED', 'PROCESSING', 'DONE']);
            $table->string('status');
            // reference to user?
            $table->foreignIdFor(User::class);

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
        Schema::dropIfExists('crawling_jobs');
    }
}
