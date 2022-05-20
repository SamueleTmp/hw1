<?php
session_start();

$data = json_decode(file_get_contents('php://input'));

$title = $data->nome_film;

$curl = curl_init();

$endpoint_completo = "http://www.omdbapi.com/?apikey=d005fec5&t=".$title;


curl_setopt($curl, CURLOPT_URL, $endpoint_completo);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//Questo lo restituisco al javascript
$result = curl_exec($curl);

$tmp = json_decode($result, true);

$lunghezza = count($tmp);

if($lunghezza > 3)
{
    echo $result;
}
else
{
    $array= array();
    $array['success']="Film non trovato!";

    echo json_encode($array);
}



curl_close($curl);


?>