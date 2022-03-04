<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchIdToCrawlingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawling_jobs', function (Blueprint $table) {
            // add before created at
            $table->after('user_id', function (Blueprint $table) {
                $table->string('batch_id')->nullable()->index();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawling_jobs', function (Blueprint $table) {
            // drop column
            $table->dropColumn('batch_id');
        });
    }
}
