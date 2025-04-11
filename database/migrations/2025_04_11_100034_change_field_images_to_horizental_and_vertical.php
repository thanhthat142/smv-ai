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
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('image', 'vertical_image');
            $table->string('horizontal_image')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('image', 'vertical_image');
            $table->string('horizontal_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('vertical_image', 'image');
            $table->dropColumn('horizontal_image');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('vertical_image', 'image');
            $table->dropColumn('horizontal_image');
        });
    }
};
