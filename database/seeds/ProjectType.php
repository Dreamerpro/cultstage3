<?php

use Illuminate\Database\Seeder;

class ProjectType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $array=['Movie','Album','Short Film'];

        foreach ($array as $item) {
        	$ps=new App\Models\Detail\ProjectType;
        	$ps->name=$item;
        	$ps->save();
        }
    }
}
