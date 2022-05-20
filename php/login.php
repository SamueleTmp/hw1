<?php 
    //Faccio partire una sessione e verifico se sono già presentu dati
    session_start();
    if(isset($_SESSION['username']))
    {
        //Vado alla home
        header("Location: homepage.php");
        exit;
    }

    //Se non era presente nessuna sessione verifico la correttezza dei dati acquisiti con POST
    if(isset($_POST['username']) && isset($_POST['pass']))
    {
        //Mi connetto al server
        $conn = mysqli_connect("localhost", "root", "", "homework");

        //evito la SQL Injection
        $usr = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        //Verifica delle credenziali connettendomi al server
        
        $query = "SELECT * FROM utenti WHERE username='" . $usr . "'";
        $res = mysqli_query($conn, $query);

        //Verifico che mi sia tornata una riga
        if(mysqli_num_rows($res)==1)
        {
            //Ottengo la tupla (username, pass)
            $row=mysqli_fetch_row($res);
            if($row[0] == $usr && $row[1] == $pass)
            {
                $_SESSION['username']=$row[0];
                //Chiudo la connesione
                mysqli_free_result($res);
                mysqli_close($conn);
                header("Location: homepage.php");
                exit;   
            }
            else
            {
                //Setto un flag di errore
                $errore= true;
            }
        }
        else
        {
            //Necessario settare anche qui un errore nel caso non fosse presente alcuna tupla
            $errore=true;            
        }
        //Chiudo la connesione
        mysqli_free_result($res);
        mysqli_close($conn);


        
    }


?>

<!DOCTYPE html>
<html>
    <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>LOGIN</title>

        <link rel="stylesheet" href="../css/login.css">
        
        <script src="../js/login.js" defer="true"></script>
    </head>

    <body>

            <div class="login_container">
                <div class="left">
                    <img src="https://cdn.pixabay.com/photo/2017/11/24/10/43/ticket-2974645_960_720.jpg" alt="immagine_login">
                </div>
                <div class="right">
                    
                    <form action="" name="login_form" method="post">
                        <p id="welcome">Benvenuto su CineSocial!</p>
                        <div>
                            <label>Username<input type="text" name="username"></label>
                        </div>
                        <div>
                            <label>Password<input type="password" name="pass"></label>
                        </div>
                        <div id="invio">
                            <input type="submit" name="access" value="Accedi">    
                        </div>
                        <!--Lo spazio si fa con Alt+255 -->
                        <div>Non sei iscritto?  <a href="register.php">Registrati</a></div>
                        
                        
                        <?php
                             
                            if(isset($errore))
                            {
                                echo "<p class='error'> Credenziali Non Valide </p>";
                            }
                            
                        ?>


                    </form>
                </div>
            </div>
            
    </body>
</html>