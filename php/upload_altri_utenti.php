<?php
    session_start();

    $data = json_decode(file_get_contents('php://input'));

    $utente = $data->nome_utente;


    $row=array();

    if(isset($_SESSION['username']))
    {
        //Mi connetto al server
        $conn = mysqli_connect("localhost", "root", "", "homework");

        $utente = mysqli_real_escape_string($conn, $utente);
            
        $query_upload_utente = "SELECT * 
        FROM pic_profile
        WHERE username = '".$utente."'";
        
        //Eseguo la query
        $result_upload_utente= mysqli_query($conn, $query_upload_utente);

        $row_upload_utente = mysqli_fetch_row($result_upload_utente);

        $row[0] = $row_upload_utente[0];
        $row[1] = base64_encode($row_upload_utente[1]);


        $_SESSION['ricerca_utenti']=$row_upload_utente[0];


        mysqli_free_result($result_upload_utente);
        mysqli_close($conn);
        
        
        echo json_encode($row);
    }

?>