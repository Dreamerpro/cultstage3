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
    	$roles_array=[
            "Actor",
            "Actress",
            "Comedian",
            "Supporting Actor",
            "Supporting Actress",
            "Models",
            "Child Artists",
            "Aged Characters",

            "Music Director",
            "Playback Singers",
            "Track Singers",
            "Instrumentalists",
            "Music Programmers",
            "Dubbing Facilities",
            "Recording Studios",
            "DTS Studios",
            "Mixing and Mastering Team",
            "Dubbing Artist",
            "Sound Engineers",

            "Shooting Permission",
            "Film Chamber/Title Registration",
            "Censor Board",
            "Producers Association",
            "Director Association",

            "Publicity Designers",
            "Advertising Agencies",
            "Distributors",
            "Audio Companies",
            "Audio Releasing Premises",
            "Online Promotion",
            "Railway Marketing",
            "BMTC/KSRTC Bus Marketing",
            "FM Marketing/Jingles",
            "Local Cable Marketing",
            "Preview Theatres",
            "Event Management",

            "Directors",
            "Associate Directors",
            "Art Director",
            "Cinematographers",
            "Cinema Story, Screenplay & Dialogue writers",
            "Lyricists",
            "Choreographers",
            "Dancers",
            "Stunt Directors & Masters",
            "Fighters",
            "Production Executives",
            "Make-up Artists",
            "Hair Stylists",
            "Costume Designers",
            "Cinema Advertisement Designers",
            "Still Photographers",
            "Cinema Vehicle Drivers",
            "Cinema Production Assistance",
            "Cinema Journalists",
            "Cinema Photo Journalists"
        ];

        // $i=1;
        foreach ($roles_array as $value) {
        	$roles=App\Models\Detail\Roles::firstOrCreate(["name"=>$value]);
        	// $i++;
        }

    }
}
