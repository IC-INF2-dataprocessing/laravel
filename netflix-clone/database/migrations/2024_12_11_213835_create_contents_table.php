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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Genre::class)->constrained()->nullable();
            $table->string('title');
            $table->timestamp('duration');
            $table->timestamps();
        });

        Schema::create('content_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Content::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Profile::class)->constrained()->onDelete('cascade');
            $table->timestamp('progress');
            $table->unsignedInteger('watch_count');
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
        Schema::dropIfExists('contents');
    }
};
