<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_medias', function (Blueprint $table)
        {
            $table->id();
            // media of the related post
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->text('file_path');
            $table->enum('type',['image','video','pdf','pptx']);
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
        Schema::dropIfExists('post_medias');
    }
};
