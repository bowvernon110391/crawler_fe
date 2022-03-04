<?php
// namespace App\Helpers;

if (!function_exists('array_duplicate')) {
    function array_duplicate(array $arr) {
        // check if there's a duplicate values inside array,
        // works for strings only!
        for ($i=0; $i < count($arr)-1; ++$i) {
            for ($j=$i+1; $j < count($arr); ++$j) {
                /* if ($i == $j)
                    continue; */

                // do the checking
                if (strtoupper(strval($arr[$i])) == strtoupper(strval($arr[$j]))) {
                    return $arr[$i];
                }
            }
        }

        return null;    // no duplicate
    }
}