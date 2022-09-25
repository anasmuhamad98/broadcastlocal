<?php

namespace Database\Seeders;

use App\Models\AccessToken;
use App\Models\PersonalAccessToken;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // declaring and defining table name and path to csv
        $table = 'token';
        $file = public_path("/seeders/$table" . ".csv");

        //import CSV function
        function import_CSV_token($filename, $delimiter = ',')
        {
            if (!file_exists($filename) || !is_readable($filename))
                return false;
            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            return $data;
        }

        // store returned data into array of records
        $records = import_CSV_token($file);

        // add each record to the posts table in DB
        foreach ($records as $key => $record) {
            PersonalAccessToken::create([
                'tokenable_type' => $record['Grouper'],
                'tokenable_id' => $record['Grouper'],
                'name' => $record['Grouper'],
                'token' => $record['Grouper'],
                'abilities' => $record['Grouper'],
            ]);
        }


    }
}
