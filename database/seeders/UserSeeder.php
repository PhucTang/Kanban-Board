<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Luke Skywalker', 
            'profile_picture_url' => '/img/lukeskywalker.jpg',
            'email' => 'Farmboy2Jedi@TheForce.net',
        ]);
        User::factory()->create([
            'name' => 'Princess Leia Organa', 
            'profile_picture_url' => '/img/princessleiaorgana.jpg',
            'email' => 'RebelLeaderInHeels@GalaxyMail.com',
        ]);
        User::factory()->create([
            'name' => 'Han Solo', 
            'profile_picture_url' => '/img/hansolo.webp',
            'email' => 'KesselRunRecordHolder@FalconMail.com',
        ]);
        User::factory()->create([
            'name' => 'Darth Vader', 
            'profile_picture_url' => '/img/darthvader.webp',
            'email' => 'BreathingIsComplicated@DarkSide.net',
        ]);
        User::factory()->create([
            'name' => 'Chewbacca', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Chewbacca@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'David', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'David@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Leona', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Leona@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Vin', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Vin@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Rock', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Rock@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Vica', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Vica@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Messi', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Messi@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Ronaldo', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Ronaldo@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Ablade', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Ablade@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Thomas', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Thomas@WookieeWorld.com',
        ]);
        User::factory()->create([
            'name' => 'Lidma', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'Lidma@WookieeWorld.com',
        ]);
    }
}
