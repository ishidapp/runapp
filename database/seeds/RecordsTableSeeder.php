<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->first();
        $distances = [10, 20, 12];

        foreach ( $distances as $distance ) {
            DB::table('records')->insert([
                'user_id'    => $user->id,
                'date'       => Carbon::now(),
                'distances'  => $distance,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
