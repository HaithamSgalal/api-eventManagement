<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use PhpParser\Node\Stmt\For_;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        For($i = 0 ; $i <  200 ; $i++ ):
        
        $user = $users->random();

        Event::Factory()->create([
            "user_id" => $user->id,
        ]) ;

        endfor;
        
    }
}
