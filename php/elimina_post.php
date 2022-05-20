<?php

session_start();

$data = json_decode(file_get_contents('php://input'));

$id_post = $data->id;


if(isset($_SESSION['username']))
{

    $conn = mysqli_connect("localhost", "root", "", "homework");

    $query_remove_post="DELETE FROM published_post WHERE id = ".$id_post;

    mysqli_query($conn, $query_remove_post);

    mysqli_close($conn);
    
}

?>