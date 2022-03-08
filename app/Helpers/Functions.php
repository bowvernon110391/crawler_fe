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

if (!function_exists('find_binary')) {
    function find_binary($bin) {
        // just execute the path, check if it's working
        if (preg_match('/^(\w+)\s/i', php_uname(), $matches)) {
            // we find a match, check it
            switch ($matches[1]) {
                case 'Linux':
                    exec("which {$bin}", $result, $stat);

                    if (!$stat) {
                        return $result[0];
                    }
                    break;

                case 'Windows':
                    exec("where {$bin}", $result, $stat);

                    if (!$stat) {
                        return $result[0];
                    }
                    break;
            }
        }
        // return as is?
        return null;
    }
}

if (!function_exists('check_python_version')) {
    /**
     * ensure that python 3 is in this path
     */
    function check_python_version($bin_path) {
        exec("{$bin_path} --version", $result, $stat);

        // version check success. check for the real version
        if (!$stat) {
            // print_r($result);
            if (preg_match('/python\s(\d).+/i', $result[0], $matches) && $matches[1] == '3') {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('build_crawl_command')) {
    function build_crawl_command($keyword, $page, $number, $lockId) {
        $script_path = base_path('submodules/crawler/crawl_tokopedia.py');
        $python_bin = find_binary('python') ?? find_binary('python3');    // should resolve automatically :p

        // make sure binary exists
        if (!$python_bin) {
            throw new \Exception("Cannot find python! make sure it's within PATH variable", 1);
        }

        // make sure the file exists
        if (!file_exists($script_path)) {
            throw new \Exception("Cannot find crawl_tokopedia.py! make sure it's located at '{$script_path}'", 2);
        }

        return "{$python_bin} {$script_path} -l \"{$lockId}\" -p {$page} -n {$number} \"{$keyword}\"";
    }
}