<?php

use Illuminate\Database\Seeder;

class Languages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang_array=['Kannada','Hindi','Marathi'];

        $i=0;
        foreach ($lang_array as $value) {
        	$lang=new App\Models\Detail\Language;
        	$lang->language= $value;
        	$lang->language_id=$i+1;
        	$lang->save();	
        	$i++;
        }
    }
}
