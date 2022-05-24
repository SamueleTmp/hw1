<?php
    session_start();

    //verifico se l'utente è loggato
    if(!isset($_SESSION['username']))
    {
        //Nel caso in cui non fosse loggato vado nella paggina di login
        header("Location: login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>CineSocial</title>
     
        <link rel="stylesheet" href="../css/profilo.css">
        <link rel="stylesheet" href="../css/bacheca.css">
        
        <script src="../js/profilo_altri_utenti_post.js" defer="true"></script>
        <script src="../js/profilo_altri_utenti.js" defer="true"></script>

    </head>

    <body>
        
            <header>
                <nav>
                        <a href="homepage.php">Home</a>
                        <h1>CineSocial</h1>
                        <a href="profilo.php">Profilo</a>
        
                </nav>

                        
            </header>   
        <article>
            <section class="flex_container">

                <div class="flex_left"> <!--Questo div contiene le info sull'utente che prenderò dalla sessione-->
                    <div class="up">
                        
                    </div>

            
                </div>
            

                
                <div class="flex_center">

                
                    <div class="bacheca">

                    


                    </div>
             
                
           
                </div>

            </section>



            <footer>
                Powered By Samuele Tempio 1000002420 --- API From OMDB
            </footer>


        </article>
    </body>

</html>