<!DOCTYPE html>
    <html class="no-js" lang="fr">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/foundation.css">
        <title>Login</title>
    </head>

    <body> 
    <div class="grid-container">

<?php //---------------------------------------------------------Début formulaire------------------------------------------------------------?>
        <div class="grid-x grid-padding-x">
            <div class="large-12 cell">
                <h1>Bienvenue sur mon site</h1>
                <p>Veuillez vous connecter</p>
            </div>
        </div>

       <form action='formConnexion.php' method='post'>
               <label> Mail : </label>
               <input type='text' name='email' placeholder="xxxxx@gmail.com"/>
               <label> Mot de passe :  </label>
               <p><input type='password' name='mdp'/></p>
            <input class="simple button" type='submit' name ='connexion' value='Connexion'>
            <p><a href="formInscription.php">Je créé mon compte</a></p>
       </form>
    <?php //---------------------------------------------------------Fin formulaire------------------------------------------------------------


        //Si le formulaire a été validé : 
        if(isset($_POST['connexion'])){
            //Je récupère les données de mon formulaire 
            $mail = $_POST['email'];
            $password = $_POST['mdp'];
            //Si les champs ne sont pas vides :
            if(!empty($mail) && !empty($password)){
                //Je me connecte à la BDD 
                include 'connexionBdd.php';

                //Je decrypte le mot de passe 
                $password = hash('sha256', $password);
                //Je créé ma requête SQL : Je vais chercher la ligne avec le mail entré par l'utilisateur
                $sql = "SELECT id_individu,pseudo, mail, mot_de_passe FROM individus WHERE mail='".$mail."' AND mot_de_passe='".$password."'" ;
                
                //J'envoie la requête à la BDD et je l'enregistre dans une variable
                $reponse = $bdd ->query($sql);
                
                //Si le mot de passe correspond à la ligne email, on accueille l'utilisateur
                if ($donnees = $reponse->fetch()){
                    header('location: dashboard.php');
                    exit;
                } else {
                    //Si le mot de passe ne correspond pas, on échoue la connexion
                    echo "Mail ou mot de passe invalide";
                }
            } else{
                echo "Tous les champs doivent être complétés";
            } 

            //Si un des champs est vide, on demande à l'utilisateur de tout compléter 
            }

    ?>
    
</div>
</body>
</html>