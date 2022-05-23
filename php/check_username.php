<?php
    session_start();

    $check = array();

    $data = json_decode(file_get_contents('php://input'));

    $username = $data->username;

    $conn = mysqli_connect("localhost", "root", "", "homework");

    $usr = mysqli_real_escape_string($conn, $username);
    
    $query = "SELECT username FROM utenti WHERE username = '" . $usr . "'";
           
    $res = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($res)>0)
    {
        $check['status']="Username già esistente";
    }
    else
    {
        $check['status']="Username Libero";
    }

   
    mysqli_free_result($res);
    mysqli_close($conn);
   
    echo json_encode($check);

?>
