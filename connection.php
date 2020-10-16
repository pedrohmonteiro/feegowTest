<?php

// A function that will make a GET request to the /campaigns endpoint


get_data_from_api();

function get_data_from_api()
{

    $url = "https://api.feegow.com/v1/api/specialties/list/?Host=api.feegow.com/v1&Content-Type=application/json&x-access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38";
    // $host = "Host=api.feegow.com/v1&";
    // $contentType = "Content-Type=application/json&";
    // $token = "x-access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38";
    
    // $url = $url + $host + $contentType + $token;
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);

    $dataJson = curl_exec($ch);
    
    if($dataJson == false){
        die(curl_error($ch));
    }
    
    
    // echo $dataJson;
    
    $dataObj = json_decode($dataJson, true);

    $array = $dataObj['content'];

    foreach ($array as $key => $val){
        // Do stuff while traversing array
        // echo  nl2br ("    Inside the loop: " . $val['especialidade_id']. " " . $val['nome'] . ".\n");
        echo'<option value='.$val['especialidade_id'].'>'.$val['nome'].'</option>';
    }
    // return $dataObj;

}


