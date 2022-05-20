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
    $query_ins = "INSERT INTO liked_post(id_post, username) VALUES ('$id_post','$usr')";

    mysqli_query($conn, $query_ins);

    mysqli_close($conn);
}
?>