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
        	$ps=App\Models\Detail\ProjectType::firstOrCreate(["name"=>$item]);;
        /*	$ps->name=$item;
        	$ps->save();*/
        }
    }
}
