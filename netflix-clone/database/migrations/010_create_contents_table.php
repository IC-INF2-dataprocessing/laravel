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
            $table->string('title');
            $table->timestamp('duration');
            $table->string('content_path');
            $table->bigInteger('watch_count');
            $table->timestamps();
        });

        Schema::create('content_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Content::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Profile::class)->constrained()->onDelete('cascade');
            $table->timestamp('progress');
            $table->unsignedInteger('watch_count')->default(0);
            $table->timestamps();
        });

        Schema::create('watch_list', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Profile::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Content::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Series::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('series_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Content::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Series::class)->constrained()->onDelete('cascade');
            $table->unsignedInteger('episode_id');
            $table->unsignedInteger('season_id')->default(1);
            $table->timestamps();
        });

        Schema::create('content_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Series::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Genre::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('content_progress');
        Schema::dropIfExists('watch_list');
        Schema::dropIfExists('series_episodes');
        Schema::dropIfExists('content_genre');
        Schema::dropIfExists('contents');
    }
};
