<?php
 session_start();



 //verifico se l'utente è loggato
 if(isset($_SESSION['username']))
 {
     $array=array();
     //Mi connetto al server
     $conn = mysqli_connect("localhost", "root", "", "homework");

     $usr= mysqli_real_escape_string($conn, $_SESSION['username']);

     $query_picprofile = "SELECT picprofile FROM utenti as U JOIN pic_profile as P
     ON U.username=P.username
     WHERE P.username = '".$usr."'";
     
     $query_post_pubblicati = "SELECT count(*) as numero_post_pubblicati
     FROM utenti as U JOIN published_post as PP
     ON U.username=PP.utente
     WHERE U.username= '".$usr."'";
    

     $query_like_ricevuti ="SELECT sum(PP.nlike) 
     FROM published_post as PP
     WHERE PP.utente='".$usr."'";

     $query_like_fatti = "SELECT count(*) as numero_like_messi
     FROM liked_post as U
     WHERE U.username='".$usr."'";

    $picprofile = mysqli_query($conn, $query_picprofile);

    $post_pubblicati = mysqli_query($conn, $query_post_pubblicati);

    $like_ricevuti = mysqli_query($conn, $query_like_ricevuti);

    $like_fatti= mysqli_query($conn, $query_like_fatti);


    $post_pubblicati=mysqli_fetch_row($post_pubblicati);

    $like_ricevuti=mysqli_fetch_row($like_ricevuti);

    $like_fatti= mysqli_fetch_row($like_fatti);

    $row_picprofile = mysqli_fetch_assoc($picprofile);

    $final_picprofile = base64_encode($row_picprofile['picprofile']);

    

    $array['picprofile']=$final_picprofile;
    $array['username']=$usr;
    $array['post_pubblicati']=$post_pubblicati[0];
    $array['like_ricevuti']=$like_ricevuti[0];
    $array['like_fatti']=$like_fatti[0];

   


    mysqli_close($conn);
   
     
    echo json_encode($array);
 }





?>