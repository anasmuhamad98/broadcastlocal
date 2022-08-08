<?php

namespace Database\Seeders;

use App\Models\Grouper;
use Illuminate\Database\Seeder;

class GrouperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // declaring and defining table name and path to csv
        $table = 'groupers';
        $file = public_path("/seeders/$table" . ".csv");

        //import CSV function
        function import_CSV($filename, $delimiter = ',')
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
        $records = import_CSV($file);

        // add each record to the posts table in DB
        foreach ($records as $key => $record) {
            Grouper::create([

                'Grouper' => $record['Grouper'],
                'Meaning' => utf8_encode($record['Meaning']),
                'Tack_1' => $record['Tack_1'] ?? 0,
                'Tack_2' => $record['Tack_2'] ?? 0,
                'Tack_3' => $record['Tack_3'] ?? 0,
                'Tack_4' => $record['Tack_4'] ?? 0,
                'Free_Text_Tack_1' => $record['Free_Text_Tack_1'] ?? 0,
                'Free_Text_Tack_2' => $record['Free_Text_Tack_2'] ?? 0,
                'Free_Text_Tack_3' => $record['Free_Text_Tack_3'] ?? 0,
                'Free_Text_Tack_4' => $record['Free_Text_Tack_4'] ?? 0,
                'Free_Text_Tack_5' => $record['Free_Text_Tack_5'] ?? 0,
                'Free_Text_Tack_6' => $record['Free_Text_Tack_6'] ?? 0,
                'List_A' => $record['List_A'] ?? 0,
                'List_B' => $record['List_B'] ?? 0,
                'List_C' => $record['List_C'] ?? 0,
                'Free_Text_List' => $record['Free_Text_List'] ?? 0
            ]);
        }
    }
}
