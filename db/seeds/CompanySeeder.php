<?php

use Phinx\Seed\AbstractSeed;

class CompanySeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];

        for($i = 0; $i < 10; $i++) {
            $data[] = [
                'name' => $faker->company,
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'active_ind' => 0,
                'alive_ind' => 0,
            ];
        }
        //$table->string('street');
        //$table->string('city');
        //$table->string('state');
        //$table->string('zip');
        //$table->boolean('active_ind');
        //$table->boolean('alive_ind');

        $this->insert('companies', $data);
    }
}
