<?php

// A function that will make a GET request to the /campaigns endpoint
$funcao = $_POST["funcao"];

if ($funcao == 'get_data_from_api') {
    call_user_func($funcao);
}
if ($funcao == 'get_data_from_api_profissional') {
    call_user_func($funcao);
}
if ($funcao == 'grava_agendamento') {
    call_user_func($funcao);
}

// função para pegar dados da api
function get_data_from_api()
{
    $url = $_POST["url"];
    $host = $_POST["host"];
    $contentType = $_POST["contentType"];
    $token = "x-access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38";

    $final_url = $url . "?" . $host . "&" . $contentType . "&" . $token;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $final_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);

    $dataJson = curl_exec($ch);

    if ($dataJson == false) {
        die(curl_error($ch));
    }

    echo $dataJson;
    return;
}

// função para pegar dados do profissional da api
function get_data_from_api_profissional()
{
    $url = $_POST["url"];
    $host = $_POST["host"];
    $contentType = $_POST["contentType"];
    $token = "x-access-token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38";
    $id = $_POST["id"];

    $final_url = $url . "?" . $host . "&" . $contentType . "&" . $token . "&" . $id;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $final_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);

    $dataJson = curl_exec($ch);

    if ($dataJson == false) {
        die(curl_error($ch));
    }

    echo $dataJson;
    return;
}

// função para gravar dados no banco
function grava_agendamento()
{
    $nome = "'" . $_POST["nome"] . "'";
    $dataNascimento = "'" . $_POST["dataNascimento"] . "'";
    $comoConheceu = "'" . $_POST["comoConheceu"] . "'";
    $cpf = "'" . $_POST["cpf"] . "'";
    $specialtyId = "'" . $_POST["specialtyId"] . "'";
    $profissionalId = "'" . $_POST["profissionalId"] . "'";
    $dateTime = "'" . date("Y-m-d H:i:s") . "'";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "clinica";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO agendamento (specialty_id,professional_id,name,cpf,source_id,birthdate,date_time) 
    VALUES ( $specialtyId, $profissionalId, $nome, $cpf, $comoConheceu, $dataNascimento,$dateTime)";

    print_r($sql);

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
