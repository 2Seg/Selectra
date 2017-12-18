<?php
/**
 * Created by PhpStorm.
 * User: eliottdes
 * Date: 18/12/17
 * Time: 10:03
 */

function calculateYearlyElectricalBill ($jsonFile) {

    // Making sure the file is a json file
    if (pathinfo($jsonFile, PATHINFO_EXTENSION) != "json") {
        return "This file is not a json file.";
    }

    // Converting the json file in a workable array
    $data = json_decode(file_get_contents($jsonFile), true);

    $contracts = $data['contracts'];
    $providers = $data['providers'];
    $users = $data['users'];

    $output = array("bills" => array());

    for ($i = 0; $i < count($contracts); $i++) {
        for ($j = 0; $j < count($providers); $j++) {
            for ($k = 0; $k < count($users); $k++) {

                if ($contracts[$i]['provider_id'] == $providers[$j]['id'] && $contracts[$i]['user_id'] == $users[$k]['id']) {
                    $output["bills"][$k]['id'] = $k + 1;

                    $rawBill = $providers[$j]['price_per_kwh'] * $users[$k]['yearly_consumption'];

                    if ($contracts[$i]['contract_length'] <= 1) {
                        $output["bills"][$k]['price'] = $rawBill - $rawBill * 0.1;
                    } elseif ($contracts[$i]['contract_length'] <= 3) {
                        $output["bills"][$k]['price'] = $rawBill - $rawBill * 0.2;
                    } else {
                        $output["bills"][$k]['price'] = $rawBill - $rawBill * 0.25;
                    }

                    $output["bills"][$k]['user_id'] = $users[$k]['id'];
                }
            }
        }
    }

    // Converting the array in json file
    $jsonOutput = json_encode($output);

    return $jsonOutput;

}

// Test :
echo calculateYearlyElectricalBill("data.json");