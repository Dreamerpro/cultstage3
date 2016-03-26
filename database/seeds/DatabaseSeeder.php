<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(Events::class);
         $this->call(Languages::class);
         $this->call(Locations::class);
         $this->call(ProductionStage::class);
         $this->call(ProjectType::class);
         $this->call(Role::class);
    }
}
