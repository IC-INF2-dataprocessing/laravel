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
        Schema::create('video_qualities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('content_video_quality', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Content::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\VideoQuality::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('video_qualities');
        Schema::dropIfExists('content_video_quality');
    }
};
