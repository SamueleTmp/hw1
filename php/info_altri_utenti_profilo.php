<?php
 session_start();



 //verifico se l'utente è loggato
 if(isset($_SESSION['ricerca_utenti']))
 {
     $array=array();
     //Mi connetto al server
     $conn = mysqli_connect("localhost", "root", "", "homework");

     $usr= mysqli_real_escape_string($conn, $_SESSION['ricerca_utenti']);

     $query_picprofile = "SELECT picprofile FROM utenti as U JOIN pic_profile as P
     ON U.username=P.username
     WHERE P.username = '".$usr."'";
     

    $picprofile = mysqli_query($conn, $query_picprofile);



    $row_picprofile = mysqli_fetch_assoc($picprofile);

    $final_picprofile = base64_encode($row_picprofile['picprofile']);

    

    $array['picprofile']=$final_picprofile;
    $array['username']=$usr;
     

    mysqli_free_result($picprofile);
    mysqli_close($conn);
   
    echo json_encode($array);
 }