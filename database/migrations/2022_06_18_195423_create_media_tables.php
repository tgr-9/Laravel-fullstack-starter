<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_uploaded', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name');
            $table->unsignedBigInteger('size');
            $table->string('path');
            $table->string('mime');
            $table->string('type');
            $table->string('url')->nullable();
            $table->json('meta')->nullable();
            $table->string('disk')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('files_attachables', function (Blueprint $table) {
            $table->foreignUuid('file_id')->index();
            $table->morphs('attachable');

            $table->foreign('file_id')->references('id')->on('files_uploaded')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_attachables');
        Schema::dropIfExists('files_uploaded');
    }
};
