<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabaseTriggers extends Command
{
    protected $signature = 'db:create-triggers';
    protected $description = 'Create Database Triggers';

    public function handle(): void
    {
        try {
            // Drop the trigger if it already exists
            DB::statement('DROP TRIGGER IF EXISTS before_insert_profile');

            // Create the trigger
            DB::statement('
                CREATE TRIGGER before_insert_profile
                BEFORE INSERT ON profiles
                FOR EACH ROW
                BEGIN
                    DECLARE profile_count INT;

                    SELECT COUNT(*) INTO profile_count
                    FROM profiles
                    WHERE user_id = NEW.user_id;

                    IF profile_count >= 4 THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "A user cannot have more than 4 profiles.";
                    END IF;
                END
            ');

            $this->info('Trigger created successfully.');
        } catch (\Exception $e) {
            $this->error('Error creating triggers: ' . $e->getMessage());
        }
    }
}
