<?php
session_start();

$data = json_decode(file_get_contents('php://input'));

$title = $data->nome_film;
$desc = $data->descrizione;

$curl = curl_init();

$endpoint_completo = "http://www.omdbapi.com/?apikey=d005fec5&t=".$title;


curl_setopt($curl, CURLOPT_URL, $endpoint_completo);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//Questo lo restituisco al javascript
$result = curl_exec($curl);

$tmp = json_decode($result, true);

$lunghezza = count($tmp);

//Salvo le informazioni del post sul DB

if(isset($_SESSION['username']) && $lunghezza > 3)
{
    //Questo lo uso per prendere i dati della query
   

    $conn = mysqli_connect("localhost", "root", "", "homework");

    //Evito l'sql injection
    $usr = mysqli_real_escape_string($conn, $_SESSION['username']);
    $titolo = mysqli_real_escape_string($conn, $tmp['Title']);
    $desc = mysqli_real_escape_string($conn, $desc);
    $anno = mysqli_real_escape_string($conn, $tmp['Year']);
    $durata = mysqli_real_escape_string($conn, $tmp['Runtime']);
    $poster = mysqli_real_escape_string($conn, $tmp['Poster']);

    $query = "INSERT INTO published_post(utente, titolo, anno, durata, descrizione, url_poster)
     VALUES('$usr','$titolo','$anno','$durata','$desc','$poster')";
    //Eseguo la query
    mysqli_query($conn, $query);

    //seleziono 
    $id_post = mysqli_insert_id($conn);

    //Libero e chiudo
    mysqli_close($conn);
    
    $array= array();
    $array['anno']=$anno;
    $array['descrizione']=$desc;
    $array['durata']=$durata;
    $array['id']=strval($id_post);
    $array['nlike']="0";
    $array['titolo']=$titolo;
    $array['url_poster']=$poster;
    $array['utente']=$usr;
    $array['like']="unliked";

    echo json_encode($array);


    curl_close($curl);

}
else
{
    $array= array();
    $array['success'] = "Il film non esiste!";
    echo json_encode($array);

    curl_close($curl);    
}





?>