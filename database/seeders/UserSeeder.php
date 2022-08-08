<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // declaring and defining table name and path to csv
        $table = 'users';
        $file = public_path("/seeders/$table" . ".csv");

        //import CSV function
        function import_CSV_User($filename, $delimiter = ',')
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
        $records = import_CSV_User($file);

        // add each record to the posts table in DB
        foreach ($records as $key => $record) {
            User::create([
                'name' => $record['name'],
                'shortform' => $record['shortform'],
                'email' => $record['email'],
                'password' => $record['password'],
            ]);
        }
   }
}