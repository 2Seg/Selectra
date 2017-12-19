<?php
/**
 * Created by PhpStorm.
 * User: eliottdes
 * Date: 18/12/17
 * Time: 18:12
 */


require 'functions.php';

//print_r($argv);
//echo file_get_contents($argv[1]);
if (isset($argv[1])) {
    if (pathinfo($argv[1], PATHINFO_EXTENSION) != "json") {
        echo "Please use a valid json file.\n";
    } elseif (isset($argv[2])) {
        if (isset($argv[3])) {
            outputGeneration($argv[3], $argv[1]);
        } else {
            echo "Error. Please use required option '-t' with one of the following value:\narray, json or user.\n";
        }
    } else {
        echo "Error. Please use required option '-t' with one of the following value:\narray, json or user.\n";
    }
} else {
    echo "Please use provided 'data.json' file.\n";
}


