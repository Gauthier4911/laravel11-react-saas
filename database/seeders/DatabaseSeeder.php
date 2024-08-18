<?php

namespace Database\Seeders;

use App\Models\Features;
use App\Models\Packages;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'GAUTHIER',
            'email' => 'gauthier@gmail.com',
            'password'=> bcrypt('123456789')
        ]);
        Features::create([
            'image'=> '/asset/plus-icon-2048x2048-z6v59bd6.png',
            'route_name'=> 'feature1.index',
            'name'=> 'Calculate Sum',
            'desc'=>'Calculate sum of two numbers',
            'required_credits' => 1,
            'active' => true,
        ]);
        Features::create([
            'image'=> '/asset/929430.png',
            'route_name'=> 'feature2.index',
            'name'=> 'Calculate Difference',
            'desc'=>'Calculate difference of two numbers',
            'required_credits' => 3,
            'active' => true,
        ]);
        Packages::create([
            'name' => 'Basic',
            'price' => 5,
            'credits'=> 20,
        ]);
        Packages::create([
            'name' => 'Sliver',
            'price' => 20,
            'credits'=> 100,
        ]);
        Packages::create([
            'name' => 'Gold',
            'price' => 50,
            'credits'=> 500,
        ]);

    }
}
