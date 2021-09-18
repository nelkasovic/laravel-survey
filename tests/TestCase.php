<?php

namespace Wimando\Survey\Tests;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase as Orchestra;
use Wimando\Survey\SurveyServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Setup test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        $this->setUpDatabase();

        $this->setUpFactories();
    }

    /**
     * Setup test database.
     */
    protected function setUpDatabase()
    {
        //Package migrations
        include_once __DIR__ . '/../database/migrations/create_surveys_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_survey_questions_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_survey_answers_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_survey_entries_table.php.stub';
        include_once __DIR__ . '/../database/migrations/create_survey_sections_table.php.stub';

        (new \CreateSurveyQuestionsTable())->up();
        (new \CreateSurveysTable())->up();
        (new \CreateSurveyEntriesTable())->up();
        (new \CreateSurveyAnswersTable())->up();
        (new \CreateSurveySectionsTable())->up();
    }

    /**
     * Setup test factories.
     */
    protected function setUpFactories()
    {
        $this->withFactories(__DIR__ . '/../database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            SurveyServiceProvider::class,
        ];
    }

    /**
     * Sign in a dummy user.
     *
     * @param User|null $user
     * @return User
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?? User::forceCreate([
                'name' => 'John',
                'email' => 'john@example.com',
                'password' => 'secret',
            ]);

        $this->actingAs($user);

        return $user;
    }
}
