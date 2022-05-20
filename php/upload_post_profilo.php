<?php
    session_start();

    $row=array();
    $cont=0;
    $row_result=array();
    
    if(isset($_SESSION['username']))
    {
        //Mi connetto al server
        $conn = mysqli_connect("localhost", "root", "", "homework");

        $usr = mysqli_real_escape_string($conn, $_SESSION['username']);
            
        $query = "SELECT * 
        FROM published_post
        WHERE published_post.utente = '$usr' 
        ORDER BY RAND()
        LIMIT 10";
        
        //Eseguo la query
        $result= mysqli_query($conn, $query);

        $number = mysqli_num_rows($result);


        if($number>0)
        {
            while($row=mysqli_fetch_assoc($result))
            {

                $row_id =$row['id'];
                $query_check_like = "SELECT * 
                                    FROM liked_post 
                                    WHERE id_post = ".$row_id." AND username = '".$usr."'";  

                $result_check_like = mysqli_query($conn, $query_check_like);

                
                $number_check_like = mysqli_num_rows($result_check_like);

                if($number_check_like > 0)
                {
                    $row['like'] = "like";
                } 
                else
                {
                    $row['like'] = "unliked";
                }
                $row_result[$cont]=$row;
                $cont += 1;
            }
        }

        $final_result= json_encode($row_result);

        //chiudo la connessione
        mysqli_free_result($result);
        mysqli_free_result($result_check_like);
        mysqli_close($conn);
        
        
        echo $final_result;
    }

?>