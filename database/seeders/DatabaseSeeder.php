<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Space;
use App\Models\SpaceOwner;
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
        User::factory()->create([
            'name' => 'Eromosele Okoudoh',
            'email' => 'eromosele.okoudoh@gmail.com',
             ]);
             User::factory()->create([
                'name' => 'Jude James',
                'email' => 'eromosele.okoudoh@yahoo.com',
                 ]);
//                  User::factory(300)->create();
//                  $users = User::all()->shuffle();
//                  for($i=0; $i<60; $i++){
//          SpaceOwner::factory()->create([
//              'user_id' => $users->pop()->id
//          ]);
//                  }

//         $space_owners = SpaceOwner::all();
//         for($i=0; $i<100; $i++){
//             Space::factory()->create([
//                 'space_owner_id' => $space_owners->random()->id
//             ]);

//         }
        
//        foreach($users as $user){
//         $spaces = Space::inRandomOrder()->take(rand(0, 4))->get();
       
//        foreach($spaces as $space){
//         Booking::factory()->create([
//             'space_id' => $space->id,
//             'user_id' => $user->id
//         ]);
// }
//        }
//         $bookings = Booking::all();
//         foreach($bookings as $booking){
//      Review::factory()->create([
//         'booking_id' => $booking->id,
//         'space_id' => $booking->space_id
//  ]);
//      }
    }
}
