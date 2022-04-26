<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolymorphToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            //
            $table->dropColumn('blog_post_id');

            // $table->unsignedBigInteger('imageable_id');
            // $table->string('imageable_type');
            $table->morphs('imageable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('blog_post_id')->nullable();
            $table->dropMorphs('imageable');
        });
    }
}
