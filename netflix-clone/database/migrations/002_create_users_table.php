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
        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(\App\Models\Subscription::class)
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('payment_method')->nullable();
            $table->timestamp('blocked')->nullable();
            $table->foreignIdFor(\App\Models\Role::class)
                ->nullable() // Make role nullable
                ->constrained()
                ->onDelete('set null'); // If a role is deleted, user role becomes null
            $table->rememberToken();
            $table->timestamps();
        });


        // User Invites Table
        Schema::create('user_invites', function (Blueprint $table) {
            $table->id(); // Add primary key for the table
            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class, 'user_id2')
                ->constrained('users') // Explicitly reference the `users` table
                ->onDelete('cascade');
            $table->timestamps();
        });

        // Subscription History Table
        Schema::create('subscription_history', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Subscription::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->onDelete('cascade');
            $table->boolean('paid');
            $table->timestamp('start_date');
            $table->timestamps();
        });

        // Failed Login Attempts Table
        Schema::create('failed_login_attempt', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->onDelete('cascade');
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
        Schema::dropIfExists('failed_login_attempt');
        Schema::dropIfExists('subscription_history');
        Schema::dropIfExists('user_invites');
        Schema::dropIfExists('users');
    }
};
