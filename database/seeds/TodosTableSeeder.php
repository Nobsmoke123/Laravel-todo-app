<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //pass in the model you want to seed with fake data
        // with the number of fake data you want and then chain
        //the method to a create method
        factory(App\Todo::class, 10)->create();
    }
}