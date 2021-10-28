<?php

namespace Wimando\Survey;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Wimando\Survey\Http\View\Composers\SurveyComposer;

class SurveyServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(\Wimando\Survey\Contracts\Answer::class, \Wimando\Survey\Models\Answer::class);
        $this->app->bind(\Wimando\Survey\Contracts\Entry::class, \Wimando\Survey\Models\Entry::class);
        $this->app->bind(\Wimando\Survey\Contracts\Question::class, \Wimando\Survey\Models\Question::class);
        $this->app->bind(\Wimando\Survey\Contracts\Section::class, \Wimando\Survey\Models\Section::class);
        $this->app->bind(\Wimando\Survey\Contracts\Survey::class, \Wimando\Survey\Models\Survey::class);
    }

    public function boot(ViewFactory $viewFactory)
    {
        $this->publishes([
            __DIR__ . '/../config/survey.php' => config_path('survey.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views/' => base_path('resources/views/vendor/survey'),
        ], 'views');

        $this->mergeConfigFrom(__DIR__ . '/../config/survey.php', 'survey');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'survey');

        $viewFactory->composer('survey::standard', SurveyComposer::class);

        $this->publishMigrations([
            'create_surveys_table',
            'create_survey_questions_table',
            'create_survey_entries_table',
            'create_survey_answers_table',
            'create_survey_sections_table',
        ]);
    }

    protected function publishMigrations(array $migrations)
    {
        foreach ($migrations as $migration) {
            $migrationClass = Str::studly($migration);

            if (class_exists($migrationClass)) {
                return;
            }

            $this->publishes([
                __DIR__ . "/../database/migrations/$migration.php.stub" => database_path('migrations/' . date('Y_m_d_His',
                        time()) . "_$migration.php"),
            ], 'migrations');
        }
    }
}
