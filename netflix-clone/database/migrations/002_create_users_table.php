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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Subscription::class)->constrained();
            $table->foreignIdFor(\App\Models\Role::class)->constrained();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('payment_method');
            $table->timestamp('blocked')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_invites', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');;
            $table->foreignIdFor(\App\Models\User::class, 'user_id2')->constrained()->onDelete('cascade');;
        });

        Schema::create('subscription_history', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Subscription::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->boolean('paid');
            $table->timestamp('start_date');
            $table->timestamps();
        });

        Schema::create('failed_login_attempt', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->string('ip_address');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_invites');  
        Schema::dropIfExists('subscription_history');   
    }
};
