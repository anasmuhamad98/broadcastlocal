<?php

namespace Database\Seeders;

use App\Models\RakeCode;
use Illuminate\Database\Seeder;

class RakeCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // declaring and defining table name and path to csv
        $table = 'rakecode';
        $file = public_path("/seeders/$table" . ".csv");

        //import CSV function
        function import_CSV_RakeCode($filename, $delimiter = ',')
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
        $records = import_CSV_RakeCode($file);

        // add each record to the posts table in DB
        foreach ($records as $key => $record) {
            RakeCode::create([
                'Rake_Code' => $record['Rake_Code'],
                'Meaning' => utf8_encode($record['Meaning']),
            ]);
        }

    }
}
