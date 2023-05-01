<?php
/**
 * Created by enea dhack - 13/07/2020 18:31.
 */

namespace Vaened\Criteria\Tests;

use Vaened\Criteria\Tests\Utils\Searcher;

class DataBaseTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
        $this->setUpSeeder();
    }

    protected function searcher(): Searcher
    {
        return $this->app->make(Searcher::class);
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = $app->make('config');

        $config->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    private function setUpDatabase(): void
    {
        include_once __DIR__ . '/database/migrations/0000_00_00_000001_create_laravel_searcher_test_tables.stub';
        $this->app->make('\\CreateLaravelSearcherTestTables')->up();
    }

    private function setUpSeeder(): void
    {
        include_once __DIR__ . '/database/seeds/LaravelSearcherTestSeeder.stub';
        $this->seed('\\LaravelSearcherTestSeeder');
    }
}
