<?php

use Illuminate\Database\Seeder;

class Events extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $events=[
         'Conferences/ Trade Shows/ Expos',
         'Film Festival',
         'Industry Award Shows',
         'Local Meetings /Networking',
         'Seminar/ Training /Workshops',
         'Video/ Film Competitions',
         'Webinars',
         'Others'
         ];

        foreach ($events as $value) {
        	$event=new App\Models\Event\EventType;
        	$event->name= $value;
        	$event->save();	
        };
    }
}
