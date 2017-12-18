<?php
/**
 * Created by PhpStorm.
 * User: eliottdes
 * Date: 18/12/17
 * Time: 09:30
 */

function calculateYearlyElectricalBill ($jsonFile) {

    // Making sure the file is a json file
    if (pathinfo($jsonFile, PATHINFO_EXTENSION) != "json") {
        return "This file is not a json file.";
    }

    // Converting the json file in a workable array
    $data = json_decode(file_get_contents($jsonFile), true);

    $providers = $data['providers'];
    $users = $data['users'];

    $output = array("bills" => array());

    for ($i = 0; $i < count($providers); $i++) {
        for ($j = 0; $j < count($users); $j++) {
            if ($providers[$i]['id'] == $users[$j]['provider_id']) {
                $output["bills"][$j]['id'] = $j + 1;
                $output["bills"][$j]['price'] = $providers[$i]['price_per_kwh'] * $users[$j]['yearly_consumption'];
                $output["bills"][$j]['user_id'] = $users[$j]['id'];
            }
        }
    }

    // Converting the array in json file
    $jsonOutput = json_encode($output);

    return $jsonOutput;
}

// Test :
echo calculateYearlyElectricalBill("data.json");
