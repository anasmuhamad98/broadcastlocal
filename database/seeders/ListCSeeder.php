<?php

namespace Database\Seeders;

use App\Models\ListC;
use Illuminate\Database\Seeder;

class ListCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // declaring and defining table name and path to csv
        $table = 'list_c_s';
        $file = public_path("/seeders/$table" . ".csv");

        //import CSV function
        function import_CSV_ListC($filename, $delimiter = ',')
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
        $records = import_CSV_ListC($file);

        // add each record to the posts table in DB
        foreach ($records as $key => $record) {
            ListC::create([
                'Grouper' => $record['Grouper'],
                'List_C' => $record['List_C'],
                'Meaning' => utf8_encode($record['Meaning']),
            ]);
        }
    }
}
