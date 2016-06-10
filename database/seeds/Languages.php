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
        $lang_array=['Kannada','Hindi','Marathi',"Malayalam","Tamil","Telegu","Bengali","Assamese"];


        foreach ($lang_array as $value) {
        	$lang=App\Models\Detail\Language::firstOrCreate(["language"=>$value]);
        }
    }
}
