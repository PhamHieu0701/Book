<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach (glob(__DIR__ . '/*/*', GLOB_NOSORT) as $file) {
            /* @noinspection PhpIncludeInspection */
            include_once $file;
            $this->call(basename($file, '.php'));
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function __invoke()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));
        $this->container->instance('faker', $faker);

        return parent::__invoke();
    }
}
