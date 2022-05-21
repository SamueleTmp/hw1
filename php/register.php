<?php 
    //Setto l'array di errore
    $error = array();
    
   //Sono nella parte di registrazione,
   //quindi non verifico la presenza di una sessione
   //ma la faccio partire
   session_start();

    //Verifico la correttezza dei dati acquisiti con POST
    if(isset($_POST['nome']) && isset($_POST['cognome'])
        && isset($_POST['username']) && isset($_POST['email'])
        && isset($_POST['pass']) && isset($_POST['conf_pass']))
    {
        //Innanzitutto verifico che i singoli parametri siano corretti
        //Mi connetto al server
        $conn = mysqli_connect("localhost", "root", "", "homework");

        //Prendo le info del file
        if(!empty($_FILES["image"]["name"]))
        { 
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
             
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes))
            { 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image));
            }

        }
        else
        {
            $error[]="immagine profilo non caricata";
        }




        //Controllo che l'username sia valido
        if(!preg_match('/^[a-zA-Z0-9_]{1,16}$/', $_POST['username']))
        {
            $error[]="Username non valido";
        }
        else
        {
            //Controllo che non sia presente già nel DB
            $usr = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM utenti WHERE username = '" . $usr . "'";
            $res= mysqli_query($conn, $query);
            if(mysqli_num_rows($res)>0)
            {
                $error[]="Username già esistente";
            }
            else
            {
                //Libero lo spazio per la query
                mysqli_free_result($res);
            }
                        
        }


        //Controllo che il nome sia valido
        if(!preg_match('/^[a-zA-Z]{1,32}$/', $_POST['nome']))
        {
            $error[]="Nome non valido";
        }

        //Controllo che il cognome sia valido
        if(!preg_match('/^[a-zA-Z]{1,32}$/', $_POST['cognome']))
        {
            $error[]="Cognome non valido";
        }

        //Verifico che la password sia abbastanza lunga
        if(!preg_match('/^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',$_POST['pass']))
        {
            $error[]= "caratteri non sufficienti";
        }

        //Verico che la conferma password sia uguale
        if($_POST['pass'] != $_POST['conf_pass'])
        {
            $error[]= "conf_pass diversa da pass";
        }

        //Controllo che l'email sia scritta come un email
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $error[]="email non valida";
        }

        //se tutto funziona allora inserisco i dati nel db
        if(count($error) == 0)
        {
             $nome = mysqli_real_escape_string($conn, $_POST['nome']);
             $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
             $email = mysqli_real_escape_string($conn, $_POST['email']);
             $pass = mysqli_real_escape_string($conn, $_POST['pass']);
             //$usr già controllato ed evitato la SQL Injection

             $query = "INSERT INTO utenti(username, pass, nome, cognome, email)
              VALUES ('$usr', '$pass', '$nome', '$cognome', '$email')";

             $res = mysqli_query($conn, $query); 
            
             $query_picprofile= "INSERT INTO pic_profile(username, picprofile) VALUES('$usr','$imgContent')";

             $res_picprofile = mysqli_query($conn, $query_picprofile);

             print_r($res_picprofile);

             if($res)
             {
                 //Se la query va buon fine imposto i parametri di sessione
                 $_SESSION['username']=$_POST['username'];

                 //Chiudo la connesione
                 mysqli_close($conn);

                 header("Location: homepage.php");
                 exit;
             } 
        }
        else
        {
            //Nel caso fosse presente qualche errore setto un flag
            $errore=true;

        }

        //Chiudo la connessione
        mysqli_close($conn);
        
        


        
    }


?>

<!DOCTYPE html>
<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>REGISTRAZIONE</title>

        <link rel="stylesheet" href="../css/register.css">
        
        <script src="../js/register.js" defer="true"></script>
    </head>

    <body>

            <div class="register_container">
                <div class="left">
                    <img src="https://cdn.pixabay.com/photo/2017/11/24/10/43/ticket-2974645_960_720.jpg" alt="immagine_login">
                </div>
                <div class="right">
                    
                    <form action="" name="register_form" method="post" enctype="multipart/form-data">
                        <p id="welcome">Registrazione</p>
                        <div>
                            <label>Nome<input type="text" name="nome"></label>
                            <label>Cognome<input type="text" name="cognome"></label>
                        </div>
                        
                        <div>
                            <label>Username<input type="text" name="username"></label>
                            <label>Email<input type="text" name="email"></label>
                        </div>
                        
                        <div>
                            <label>Password<input type="password" name="pass"></label>
                            <label>Conferma Password<input type="password" name="conf_pass"></label>
                        </div>

                        <div>
                            <label>Foto Profilo<input type="file" name="image"></label>
                        </div>
                        

                        <div id="invio">
                            <input type="submit" name="access" value="Registrati">    
                        </div>
                        <!--Lo spazio si fa con Alt+255 -->
                        <div>Hai già un account?  <a href="login.php">Accedi</a></div>

                        <?php

                             if(isset($errore))
                             {
                                 echo "<p class='error'>Hai inserito dati errati/username già usato</p>";
                             }
                             
                         ?>
                    </form>
                </div>
            </div>
            
    </body>
</html>