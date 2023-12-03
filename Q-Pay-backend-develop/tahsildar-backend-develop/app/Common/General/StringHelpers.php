<?php

use Carbon\Carbon;

/**
 * @param string $string
 * @return string
 */
function subFirstThreeLetter(string $string): string
{
    $string = preg_replace('/\s+/', '', $string);
    $string = substr($string, 0, 3);
    return $string;
}

/**
 * @return string
 */
function getLastTwoYearNumber(): string
{
    return Carbon::now()->format('y');
}

/**
 * @param $number
 * @param $padString
 * @param $numberLength
 * @return string
 */
function setNumberLength($number, $numberLength, $padString = 0): string
{
    return str_pad($number, $numberLength, $padString, STR_PAD_LEFT);
}

/**
 * @param array $arrayElements
 * @param string $delimiter
 * @return string
 */
function convertArrayToDelimitedString(array $arrayElements, string $delimiter): string
{
    $string = '';
    //Loop Through Array Elements
    foreach ($arrayElements as $element) {
        // Check If it's the last element so no need the last delimited character.
        if ($element === end($arrayElements))
            $string .= $element;
        else
            $string .= $element . $delimiter;
    }
    return $string;
}

/**
 * @param int $length
 * @return string
 */
function generateRandomString($length = 8): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * @param $string
 * @return bool
 */
function checkStringHasNumbersAndLetter($string): bool
{
    $containsLetter = preg_match('/[a-zA-Z]/', $string);
    $containsDigit = preg_match('/\d/', $string);
    //$containsSpecial = preg_match('/[^a-zA-Z\d]/', $string);

    return $containsLetter && $containsDigit;
}

/**
 * Convert a string from kebab Case into First Capitalize case
 * (Input EX: class_name , Output EX: ClassName)
 *
 * @param $string
 * @return string
 */
function kebabToFirstCapitalized($string): string
{
    $words = explode("_", $string);
    $result = ucfirst($words[0]);
    for ($i = 1; $i < count($words); $i++) {
        $result .= ucfirst($words[$i]);
    }
    return $result;
}

/**
 * @param $tableName
 * @return string
 */
function getAliasTableName($tableName): string
{
    return strtolower(getModelNameByTable($tableName));
}

/**
 * The Str::studly method is used to convert the singularized table name to StudlyCase.
 * @param $tableName
 * @return string
 */
function getModelNameByTable($tableName): string
{
    return Str::studly(Str::singular($tableName));
}
