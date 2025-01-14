<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->longText('desc')->nullable();
            $table->text('keywords')->nullable();
            $table->longText('content')->nullable();
            $table->text('image')->nullable();
            $table->text('author')->nullable();
            $table->bigInteger('views')->nullable();
            $table->unsignedSmallInteger('status')->nullable();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->longText('desc')->nullable();
            $table->text('keywords')->nullable();
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->unique(['post_id', 'tag_id'], 'unique_post_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_tag', function (Blueprint $table){
            $table->dropUnique('unique_post_tag');
        });
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('posts');
    }
};
