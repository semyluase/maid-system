<?php

use App\Models\Counter;
use App\Models\Country;
use App\Models\Enumeration;
use App\Models\Master\Maid\Maid;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

function columnOrder(array $column, $columnOrder)
{
    return $column[$columnOrder];
}

function columnToID($model, $column, $value)
{
    $query = '';
    switch ($model) {
        case 'enumeration':
            $query = Enumeration::where($column, $value)
                ->where('is_active', true)
                ->first();
            break;

        case 'country':
            $query = Country::where($column, $value)
                ->where('is_active', true)
                ->first();
            break;

        case 'maid':
            $query = Maid::where($column, $value)
                ->first();
            break;
    }

    return $query;
}

function integerToRoman($integer)
{
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    );

    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = intval($integer / $value);

        // Add the same number of characters to the string
        $result .= str_repeat($roman, $matches);

        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}

function getAPI($uri, $query = '')
{
    $response = Http::get($uri);

    if ($query != '') {
        $response = Http::get($uri, $query);
    }

    if ($response->status() == 200) {
        return $response->object();
    } else {
        return [];
    }
}

function createCounter($period, $type)
{
    switch ($type) {
        case 'maid':
            $dataCounter = Counter::where('periode', $period)
                ->first();

            $counter = 1;
            if ($dataCounter) {
                $counter = $dataCounter->counter;

                Counter::where('periode', $period)
                    ->update([
                        'counter'   =>  $dataCounter->counter + 1
                    ]);
            } else {
                Counter::create([
                    'periode'    =>  Str::upper($period),
                    'counter'   =>  $counter
                ]);
            }

            return $period . Str::padLeft($counter, 3, '0');
    }
}

function convertSex($sexID)
{
    if ($sexID == 1) {
        return "Male";
    } else if ($sexID == 2) {
        return "Female";
    }

    return "None";
}

function convertReligion($religionID)
{
    $religion = "None";

    switch ($religionID) {
        case 1:
            $religion = "Moeslim";
            break;

        case 2:
            $religion = "Catholic";
            break;

        case 3:
            $religion = "Christian Protestant";
            break;

        case 4:
            $religion = "Buddha";
            break;

        case 5:
            $religion = "Hindu";
            break;

        case 6:
            $religion = "Confucianism";
            break;
    }

    return $religion;
}

function convertBloodType($bloodID)
{
    $blood = "None";

    switch ($bloodID) {
        case 1:
            $blood = "A";
            break;

        case 2:
            $blood = "B";
            break;

        case 3:
            $blood = "AB";
            break;

        case 4:
            $blood = "O";
            break;
    }

    return $blood;
}

function convertEducation($educationID)
{
    $education = "None";

    switch ($educationID) {
        case 1:
            $education = "Kindergarten";
            break;

        case 2:
            $education = "Primary School";
            break;

        case 3:
            $education = "Junior High School";
            break;

        case 4:
            $education = "Senior High School";
            break;

        case 5:
            $education = "Bachelor";
            break;

        case 6:
            $education = "Master";
            break;

        case 7:
            $education = "Doctor";
            break;
    }

    return $education;
}

function convertMaritalStatus($maritalID)
{
    $maritalStatus = "None";

    switch ($maritalID) {
        case 1:
            $maritalStatus = "Single";
            break;

        case 2:
            $maritalStatus = "Married";
            break;

        case 3:
            $maritalStatus = "Widowed";
            break;

        case 4:
            $maritalStatus = "Divorced";
            break;
    }

    return $maritalStatus;
}

function convertFamilyStatus($familyID)
{
    $familyStatus = "N/A";

    switch ($familyID) {
        case 1:
            $familyStatus = "Father";
            break;

        case 2:
            $familyStatus = "Mother";
            break;

        case 3:
            $familyStatus = "Spouse";
            break;

        case 4:
            $familyStatus = "Brother";
            break;

        case 5:
            $familyStatus = "Sister";
            break;

        case 6:
            $familyStatus = "Child";
            break;
    }

    return $familyStatus;
}

function convertCountry($country)
{
    switch ($country) {
        case 'HK':
            return 'is_hongkong';
            break;

        case 'SG':
            return 'is_singapore';
            break;

        case 'TW':
            return 'is_taiwan';
            break;

        case 'MY':
            return 'is_malaysia';
            break;

        case 'BN':
            return 'is_brunei';
            break;

        case 'FM':
            return 'is_all_format';
            break;
    }
}

function convertEducationLevel($education)
{
    $educationLevel = "N/A";

    switch ($education) {
        case 'Kindergarten':
            $educationLevel = "Kindergarten";
            break;

        case 2:
            $educationLevel = "Primary School";
            break;

        case 3:
            $educationLevel = "Junior High School";
            break;

        case 4:
            $educationLevel = "Senior High School";
            break;

        case 5:
            $educationLevel = "Bachelor";
            break;

        case 6:
            $educationLevel = "Master";
            break;

        case 7:
            $educationLevel = "Doctor";
            break;
    }

    return $educationLevel;
}

function excelColumn($start, $end)
{
    $columns = array();
    for ($i = $start; $i != $end; $i++) {
        $columns[]  =   $i;
    }

    return $columns;
}

function columnLetter($c)
{

    $c = intval($c);
    if ($c <= 0) return '';

    $letter = '';

    while ($c != 0) {
        $p = ($c - 1) % 26;
        $c = intval(($c - $p) / 26);
        $letter = chr(65 + $p) . $letter;
    }

    return $letter;
}

function generatePDF($html, $filename = '', $download = true, $paper = 'A4', $orientation = 'portrait')
{
    $option = new Options();
    $option->setIsRemoteEnabled(true);
    $option->setIsPhpEnabled(true);
    $option->setIsHtml5ParserEnabled(true);
    $dompdf = new Dompdf($option);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($download) {
        $dompdf->stream($filename, array('Attachment' => 1));
    } else {
        $dompdf->stream($filename, array('Attachment' => 0));
        // $output = $dompdf->output();
        // file_put_contents('pdf_handtag/' . $filename, $output);
        // $path = $filename;
        // return $path;
    }
}
