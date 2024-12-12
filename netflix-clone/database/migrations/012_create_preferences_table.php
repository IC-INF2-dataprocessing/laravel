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
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('content_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Content::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Preference::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        }); 

        Schema::create('profile_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Profile::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Preference::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('preferences');
        Schema::dropIfExists('content_preferences');
        Schema::dropIfExists('');
    }
};
