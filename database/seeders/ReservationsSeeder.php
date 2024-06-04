<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Reservations;


class ReservationsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Reservations::factory()->count(15)->create();
    }
}