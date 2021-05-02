<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNameIdeas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('name_ideas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
            $table->index(['name']);
        });

        Schema::create('name_ideas_cat_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('name_idea_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cat_type_id')->constrained('cat_types')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->index(['name_idea_id', 'cat_type_id'], 'idx_name_idea_types');
        });

        Schema::create('name_ideas_cat_characterics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('name_idea_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cat_characterics_id')->constrained('cat_characterics')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->index(['name_idea_id', 'cat_characterics_id'], 'idx_name_idea_characterics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('name_ideas_cat_types');
        Schema::dropIfExists('name_ideas_cat_characterics');
        Schema::dropIfExists('name_ideas');
    }
}
