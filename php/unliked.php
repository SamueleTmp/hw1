<?php

session_start();

$data = json_decode(file_get_contents('php://input'));

$id_post = $data->id;


if(isset($_SESSION['username']))
{

    //Questo lo uso per prendere i dati della query
    $conn = mysqli_connect("localhost", "root", "", "homework");


    $usr = mysqli_real_escape_string($conn, $_SESSION['username']);
    $id_post=mysqli_real_escape_string($conn, $id_post);

    $query_rem = "DELETE FROM liked_post WHERE id_post= ".$id_post." AND username = '".$usr."'";

    $res = mysqli_query($conn, $query_rem);
    echo $res;
    mysqli_close($conn);
}
?>