<?php

/*
* File: FileHelper.php
* Category: -
* Author: MSG
* Created: 11.03.17 13:14
* Updated: -
*
* Description:
*  -
*/


if (!function_exists('recursive_glob')) {

    /**
     * @param $dir
     * @param string $filter
     * @param array $results
     * @return array
     */
    function recursive_glob($dir, $filter = '', &$results = array()) {
        $files = scandir($dir);

        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);

            if(!is_dir($path)) {
                if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
            } elseif($value != "." && $value != "..") {
                recursive_glob($path, $filter, $results);
            }
        }

        return $results;
    }
}