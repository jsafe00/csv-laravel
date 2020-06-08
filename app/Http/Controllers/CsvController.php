<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvController extends Controller
{
    
    public function readCsv() {
        $csv = Reader::createFromPath('Records.csv', 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        echo $csv->getContent();
        
        // return response()->json($records);
    }

    // $result = ['status' => 200];

    // try {
    //     $result['data'] = $this->postService->getAll();
    // } catch (Exception $e) {
    //     $result = [
    //         'status' => 500,
    //         'error' => $e->getMessage()
    //     ];
    // }

    // return response()->json($result, $result['status']);

    public function advancedCsv() 
    {
        $stream = fopen('Records.csv', 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement())
            ->offset(10)
            ->limit(25);

        //query your records from the document
        $records = $stmt->process($csv);
        foreach ($records as $record) {
            print_r($record);
            //do something here
        }
    }

    public function searchCsv(Request $request)
    {
        $key = $request['key'];
    
        $ch = fopen("Records.csv", "r");
        $csv = Reader::createFromStream($ch);
        dd($csv);
        $header_row = fgetcsv($ch);

        while($row = fgetcsv($ch)) {
            if (preg_match('/'.$key.'/', $row = implode(' | ', $row))) {
                echo   $row;      
            }
        }
    }

}

// public function searchCsv(Request $request)
//     {
//         $key = $request['key'];
    
//         $ch = fopen("Records.csv", "r");
//         $header_row = fgetcsv($ch);

//         while($row = fgetcsv($ch)) {
           
//             if (preg_match('/'.$key.'/', $row = implode(' | ', $row))) {
//                 echo '<div>' . $row . ' </div>';
               
//             }
//         }
//     }