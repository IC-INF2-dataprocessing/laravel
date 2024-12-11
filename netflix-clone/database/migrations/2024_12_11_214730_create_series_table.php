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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Genre::class)->constrained();
            $table->timestamps();
        });

        Schema::create('content_series', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Content::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Series::class)->constrained()->onDelete('cascade');
            $table->unsignedInteger('episode_id');
            $table->unsignedInteger('season_id')->default(1);
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
        Schema::dropIfExists('series');
        Schema::dropIfExists('content_series');
    }
};
