<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabaseUsers extends Command
{
    protected $signature = 'db:create-users';
    protected $description = 'Create database users with specific permissions';

    public function handle(): void
    {
        $users = ['senior_user', 'medior_user', 'junior_user', 'api_user'];
        $hosts = [ 'localhost', '%'];
        $database = 'netflix-clone';

        try {
            foreach ($users as $user) {
                foreach ($hosts as $host) {
                    DB::statement("DROP USER IF EXISTS '{$user}'@'{$host}'");
                }
            }
            $this->info("Users zijn verwijderd.");
        } catch (\Exception $e) {
            $this->error("Fout bij het verwijderen van de users: " . $e->getMessage());
        }

        // Maak de gebruikers aan
        try {
            DB::statement("CREATE USER 'senior_user'@'%' IDENTIFIED BY 'senior_password'");
            DB::statement("CREATE USER 'medior_user'@'%' IDENTIFIED BY 'medior_password'");
            DB::statement("CREATE USER 'junior_user'@'%' IDENTIFIED BY 'junior_password'");
            DB::statement("CREATE USER 'api_user'@'%' IDENTIFIED BY 'api_password'");
        } catch (\Exception $e) {
            $this->error("Fout bij het maken van de users: " . $e->getMessage());
        }

        // Senior gebruiker
        try {
            DB::statement("GRANT ALL PRIVILEGES ON `$database`.* TO 'senior_user'@'%'");
            $this->info("Rechten toegekend aan Senior user.");
        } catch (\Exception $e) {
            $this->error("Fout bij het toekennen van de rechten aan de Senior user: " . $e->getMessage());
        }

        // Regelt de permissies
        try {
            $tables = [
                'contents',
                'content_genre',
                'content_preferences',
                'content_progress',
                'content_video_quality',
                'failed_jobs',
                'failed_login_attempt',
                'genres',
                'languages',
                'migrations',
                'password_resets',
                'personal_access_tokens',
                'preferences',
                'profiles',
                'profile_preferences',
                'roles',
                'series',
                'series_episodes',
                'series_genre',
                'subscriptions',
                'subscription_history',
                'subtitles',
                'users',
                'user_invites',
                'video_qualities',
                'watch_list',
            ];

            // Regelt de rechten voor Medior user, allesbehalve financial data
            try {
                foreach ($tables as $table) {
                    if ($table !== 'subscription_history')
                    {
                        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON `$database`.`$table` TO 'medior_user'@'%'");
                    }
                }
                $this->info("Rechten toegekend aan Medior user.");
            } catch (\Exception $e) {
                $this->error("Fout bij het toekennen van de rechten aan de Medior user: " . $e->getMessage());
            }

            // Regelt de rechten voor Junior user, allesbehalve gevoelige data
            try {
                foreach ($tables as $table) {
                    if ($table !== 'failed_login_attempt' && $table !== 'password_resets' && $table !== 'personal_access_tokens' && $table !== 'subscription_history' && $table !== 'users')
                    {
                        DB::statement("GRANT SELECT, INSERT, UPDATE ON `$database`.`$table` TO 'junior_user'@'%'");
                    }
                }
                $this->info("Rechten toegekend aan Junior user.");
            }  catch (\Exception $e) {
                $this->error("Fout bij het toekennen van de rechten aan de Junior user: " . $e->getMessage());
            }

            // Vernieuw de rechten
            DB::statement("FLUSH PRIVILEGES");
        } catch (\Exception $e) {
            $this->error("Fout bij het toekennen van de rechten: " . $e->getMessage());
        }

        $this->info('Database users created successfully.');


        // Views en de rechten toekennen
        try {
            // Views aanmaken
            try {
                DB::statement("
                CREATE OR REPLACE VIEW users_limited AS
                SELECT id, name, subscription_id, blocked, created_at, updated_at
                FROM users");
            } catch (\Exception $e) {
                $this->error("Fout bij het maken van de views: " . $e->getMessage());
            }

            // Array met alle views
            $views = [
                'contents_view' => "
                CREATE OR REPLACE VIEW contents_view AS
                SELECT *
                FROM contents
            ",
                'content_genre_view' => "
                CREATE OR REPLACE VIEW content_genre_view AS
                SELECT *
                FROM content_genre
            ",
                'content_preferences_view' => "
                CREATE OR REPLACE VIEW content_preferences_view AS
                SELECT *
                FROM content_preferences
            ",
                'content_progress_view' => "
                CREATE OR REPLACE VIEW content_progress_view AS
                SELECT *
                FROM content_progress
            ",
                'content_video_quality_view' => "
                CREATE OR REPLACE VIEW content_video_quality_view AS
                SELECT *
                FROM content_video_quality
            ",
                'failed_jobs_view' => "
                CREATE OR REPLACE VIEW failed_jobs_view AS
                SELECT *
                FROM failed_jobs
            ",
                'failed_login_attempt_view' => "
                CREATE OR REPLACE VIEW failed_login_attempt_view AS
                SELECT *
                FROM failed_login_attempt
            ",
                'genres_view' => "
                CREATE OR REPLACE VIEW genres_view AS
                SELECT *
                FROM genres
            ",
                'languages_view' => "
                CREATE OR REPLACE VIEW languages_view AS
                SELECT *
                FROM languages
            ",
                'migrations_view' => "
                CREATE OR REPLACE VIEW migrations_view AS
                SELECT *
                FROM migrations
            ",
                'password_resets_view' => "
                CREATE OR REPLACE VIEW password_resets_view AS
                SELECT *
                FROM password_resets
            ",
                'personal_access_tokens_view' => "
                CREATE OR REPLACE VIEW personal_access_tokens_view AS
                SELECT *
                FROM personal_access_tokens
            ",
                'preferences_view' => "
                CREATE OR REPLACE VIEW preferences_view AS
                SELECT *
                FROM preferences
            ",
                'profiles_view' => "
                CREATE OR REPLACE VIEW profiles_view AS
                SELECT *
                FROM profiles
            ",
                'profile_preferences_view' => "
                CREATE OR REPLACE VIEW profile_preferences_view AS
                SELECT *
                FROM profile_preferences
            ",
                'roles_view' => "
                CREATE OR REPLACE VIEW roles_view AS
                SELECT *
                FROM roles
            ",
                'series_view' => "
                CREATE OR REPLACE VIEW series_view AS
                SELECT *
                FROM series
            ",
                'series_episodes_view' => "
                CREATE OR REPLACE VIEW series_episodes_view AS
                SELECT *
                FROM series_episodes
            ",
                'series_genre_view' => "
                CREATE OR REPLACE VIEW series_genre_view AS
                SELECT *
                FROM series_genre
            ",
                'subscriptions_view' => "
                CREATE OR REPLACE VIEW subscriptions_view AS
                SELECT *
                FROM subscriptions
            ",
                'subscription_history_view' => "
                CREATE OR REPLACE VIEW subscription_history_view AS
                SELECT *
                FROM subscription_history
            ",
                'subtitles_view' => "
                CREATE OR REPLACE VIEW subtitles_view AS
                SELECT *
                FROM subtitles
            ",
                'users_view' => "
                CREATE OR REPLACE VIEW users_view AS
                SELECT *
                FROM users
            ",
                'users_limited_view' => "
                CREATE OR REPLACE VIEW users_limited_view AS
                SELECT id, name, subscription_id, blocked, created_at, updated_at
                FROM users
            ",
                'user_invites_view' => "
                CREATE OR REPLACE VIEW user_invites_view AS
                SELECT *
                FROM user_invites
            ",
                'video_qualities_view' => "
                CREATE OR REPLACE VIEW video_qualities_view AS
                SELECT *
                FROM video_qualities
            ",
                'watch_list_view' => "
                CREATE OR REPLACE VIEW watch_list_view AS
                SELECT *
                FROM watch_list
            ",
                ];

            // Array met alle stored procedures
            $storedProcedures = [
                'GetAllContents' => "
                CREATE PROCEDURE GetAllContents()
                BEGIN
                    SELECT *
                    FROM contents;
                END
            ",
                'GetAllContentGenres' => "
                CREATE PROCEDURE GetAllContentGenres()
                BEGIN
                    SELECT *
                    FROM content_genre;
                END
            ",
                'GetAllContentPreferences' => "
                CREATE PROCEDURE GetAllContentPreferences()
                BEGIN
                    SELECT *
                    FROM content_preferences;
                END
            ",
                'GetAllContentProgress' => "
                CREATE PROCEDURE GetAllContentProgress()
                BEGIN
                    SELECT *
                    FROM content_progress;
                END
            ",
                'GetAllContentVideoQualities' => "
                CREATE PROCEDURE GetAllContentVideoQualities()
                BEGIN
                    SELECT *
                    FROM content_video_quality;
                END
            ",
                'GetAllFailedJobs' => "
                CREATE PROCEDURE GetAllFailedJobs()
                BEGIN
                    SELECT *
                    FROM failed_jobs;
                END
            ",
                'GetAllFailedLoginAttempts' => "
                CREATE PROCEDURE GetAllFailedLoginAttempts()
                BEGIN
                    SELECT *
                    FROM failed_login_attempt;
                END
            ",
                'GetAllGenres' => "
                CREATE PROCEDURE GetAllGenres()
                BEGIN
                    SELECT *
                    FROM genres;
                END
            ",
                'GetAllLanguages' => "
                CREATE PROCEDURE GetAllLanguages()
                BEGIN
                    SELECT *
                    FROM languages;
                END
            ",
                'GetAllMigrations' => "
                CREATE PROCEDURE GetAllMigrations()
                BEGIN
                    SELECT *
                    FROM migrations;
                END
            ",
                'GetAllPasswordResets' => "
                CREATE PROCEDURE GetAllPasswordResets()
                BEGIN
                    SELECT *
                    FROM password_resets;
                END
            ",
                'GetAllPersonalAccessTokens' => "
                CREATE PROCEDURE GetAllPersonalAccessTokens()
                BEGIN
                    SELECT *
                    FROM personal_access_tokens;
                END
            ",
                'GetAllPreferences' => "
                CREATE PROCEDURE GetAllPreferences()
                BEGIN
                    SELECT *
                    FROM preferences;
                END
            ",
                'GetAllProfiles' => "
                CREATE PROCEDURE GetAllProfiles()
                BEGIN
                    SELECT *
                    FROM profiles;
                END
            ",
                'GetAllProfilePreferences' => "
                CREATE PROCEDURE GetAllProfilePreferences()
                BEGIN
                    SELECT *
                    FROM profile_preferences;
                END
            ",
                'GetAllRoles' => "
                CREATE PROCEDURE GetAllRoles()
                BEGIN
                    SELECT *
                    FROM roles;
                END
            ",
                'GetAllSeries' => "
                CREATE PROCEDURE GetAllSeries()
                BEGIN
                    SELECT *
                    FROM series;
                END
            ",
                'GetAllSeriesEpisodes' => "
                CREATE PROCEDURE GetAllSeriesEpisodes()
                BEGIN
                    SELECT *
                    FROM series_episodes;
                END
            ",
                'GetAllSeriesGenres' => "
                CREATE PROCEDURE GetAllSeriesGenres()
                BEGIN
                    SELECT *
                    FROM series_genre;
                END
            ",
                'GetAllSubscriptions' => "
                CREATE PROCEDURE GetAllSubscriptions()
                BEGIN
                    SELECT *
                    FROM subscriptions;
                END
            ",
                'GetAllSubscriptionHistory' => "
                CREATE PROCEDURE GetAllSubscriptionHistory()
                BEGIN
                    SELECT *
                    FROM subscription_history;
                END
            ",
                'GetAllSubtitles' => "
                CREATE PROCEDURE GetAllSubtitles()
                BEGIN
                    SELECT *
                    FROM subtitles;
                END
            ",
                'GetAllUsers' => "
                CREATE PROCEDURE GetAllUsers()
                BEGIN
                    SELECT *
                    FROM users;
                END
            ",
                'GetAllUsersLimited' => "
                CREATE PROCEDURE GetAllUsersLimited()
                BEGIN
                    SELECT id, name, subscription_id, blocked, created_at, updated_at
                    FROM users;
                END
            ",
                'GetAllUserInvites' => "
                CREATE PROCEDURE GetAllUserInvites()
                BEGIN
                    SELECT *
                    FROM user_invites;
                END
            ",
                'GetAllVideoQualities' => "
                CREATE PROCEDURE GetAllVideoQualities()
                BEGIN
                    SELECT *
                    FROM video_qualities;
                END
            ",
                'GetAllWatchList' => "
                CREATE PROCEDURE GetAllWatchList()
                BEGIN
                    SELECT *
                    FROM watch_list;
                END
            ",
            ];


        try {
            // Maak de views aan
            foreach ($views as $viewName => $viewQuery) {
                DB::statement($viewQuery);
                $this->info("View '{$viewName}' aangemaakt of bijgewerkt.");
            }

            // Maak de stored procedures aan
            foreach ($storedProcedures as $procedureName => $procedureQuery) {
                DB::statement("DROP PROCEDURE IF EXISTS {$procedureName}");
                DB::statement($procedureQuery);
                $this->info("Stored procedure '{$procedureName}' aangemaakt of bijgewerkt.");
            }

            // Ken rechten toe aan de API-gebruiker voor de views
            foreach ($views as $viewName => $viewQuery) {
                DB::statement("GRANT SELECT ON `$database`.`$viewName` TO 'api_user'@'%'");
                $this->info("Leesrechten toegekend voor view '{$viewName}' aan API user.");
            }

            // Ken rechten toe aan de API-gebruiker voor de stored procedures
            foreach ($storedProcedures as $procedureName => $procedureQuery) {
                DB::statement("GRANT EXECUTE ON PROCEDURE `$database`.`$procedureName` TO 'api_user'@'%'");
                $this->info("Uitvoerrechten toegekend voor stored procedure '{$procedureName}' aan API user.");
            }
        } catch (\Exception $e) {
            $this->error("Fout bij het toekennen van de views: " . $e->getMessage());
        }
            } catch (\Exception $e) {
            $this->error("Fout: " . $e->getMessage());
        }


    }
}
