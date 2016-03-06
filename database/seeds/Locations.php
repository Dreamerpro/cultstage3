<?php

use Illuminate\Database\Seeder;

class Locations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location_array=['Bangalore','Mumbai','Kolkata'];

        $i=0;
        foreach ($location_array as $value) {
        	$location=new App\Models\Detail\Location;
        	$location->location= $value;
        	$location->location_id=$i+1;
        	$location->save();	
        	$i++;
        }
    }
}
