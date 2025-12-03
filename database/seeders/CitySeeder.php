<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        DB::statement('PRAGMA foreign_keys = OFF;'); // SQLite
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // MySQL

        $path = database_path('seeders/data/cities.csv');
        $file = fopen($path, 'r');

        $first = true;
        $batch = [];
        $batchSize = 1000; // upsert 1000 at once

        DB::beginTransaction();

        while (($row = fgetcsv($file)) !== false) {

            if ($first) {
                $first = false;
                continue;
            }

            $batch[] = [
                'name'       => $row[1],
                'state_id'   => $row[2],
                'country_id' => $row[5],
                'lat'        => $row[8],
                'lng'        => $row[9],
            ];

            if (count($batch) >= $batchSize) {
                DB::table('cities')->upsert(
                    $batch,
                    ['name', 'state_id', 'country_id'], // UNIQUE keys
                    ['lat', 'lng']                      // fields to update
                );
                $batch = [];
            }
        }

        // Final batch
        if (!empty($batch)) {
            DB::table('cities')->upsert(
                $batch,
                ['name', 'state_id', 'country_id'], 
                ['lat', 'lng']
            );
        }

        DB::commit();

        fclose($file);

        DB::statement('PRAGMA foreign_keys = ON;');
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // MySQL
    }
}
