<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        // Disable foreign key checks only on SQLite
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        $path = database_path('seeders/data/cities.csv');
        $file = fopen($path, 'r');

        $first = true;

        DB::beginTransaction();

        while (($row = fgetcsv($file)) !== false) {

            if ($first) {
                $first = false;
                continue;
            }

            DB::table('cities')->updateOrInsert(
                [
                    // Conflict key — safest one is the ID from CSV if present.
                    'id' => $row[0], 
                ],
                [
                    'name'       => $row[1],
                    'state_id'   => $row[2],
                    'country_id' => $row[5],
                    'lat'        => $row[8],
                    'lng'        => $row[9],
                ]
            );
        }

        DB::commit();
        fclose($file);

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }
    }
}
