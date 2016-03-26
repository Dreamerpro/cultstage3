<?php

use Illuminate\Database\Seeder;

class ProductionStage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array=['Pre-Production','Production','Post-Production'];

        foreach ($array as $item) {
        	$ps=\App\ProductionStage::firstOrCreate(["name"=>$item]);
        	/*$ps->name=$item;
        	$ps->save();*/
        }
    }
}
