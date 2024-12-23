<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // Assuming you have a user in the database

        Listing::create([
            'title' => 'Test Listing 1',
            'description' => 'This is a test description for listing 1.',
            'user_id' => $user->id,
        ]);

        Listing::create([
            'title' => 'Test Listing 2',
            'description' => 'This is a test description for listing 2.',
            'user_id' => $user->id,
        ]);
    }
}
