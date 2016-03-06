<?php

use Illuminate\Database\Seeder;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles_array=['singer','actor'];

        $i=0;
        foreach ($roles_array as $value) {
        	$roles=new App\Models\Detail\Roles;
        	$roles->name= $value;
        	$roles->role_id=$i+1;
        	$roles->save();	
        	$i++;
        }

    }
}
