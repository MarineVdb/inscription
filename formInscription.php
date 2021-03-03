<!DOCTYPE html>
    <html class="no-js" lang="fr">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/foundation.css">
        <title>Inscription</title>
    </head>
<body>
<div class="grid-container">

<?php //---------------------------------------------------------Début formulaire------------------------------------------------------------?>
    <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
          <h1>Créez votre compte</h1>
        </div>
      </div>
        <form action='formInscription.php' method='post'>
                    <p>Email  <input type='text' name='email'/></p>
                    <p>Pseudo  <input type='text' name='pseudo' /></p>
                    <p>Mot de passe <input type='password' name='mdp'/></p>
                    <p><input class="simple button" type='submit' name = 'inscription' value='Inscription'></p>
                    <p><a href="formConnexion.php">J'ai déjà un compte</a></p>
        </form>

<?php //---------------------------------------------------------Fin formulaire-----------------------------------------------------------------?>


    <?php

    //On vérifie si le formulaire a été validé 
    if (isset($_POST['inscription'])){
            //On récupère les variables 
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $emailUpper = htmlspecialchars($_POST['email']);
            $email = strtolower($emailUpper);
            $mdp = htmlspecialchars($_POST['mdp']);

            //On vérifie si les champs ne sont pas vides 
            if(!empty($pseudo) && !empty($email) && !empty($mdp)){
                //Si les champs ne sont pas vides, on se connecte à la BDD
                include 'connexionBDD.php';

                //On vérifie si le mail est existant dans la BDD
                    //J'écris ma requête (PDO)
                    $requeteMail = $bdd->prepare("SELECT mail FROM individus WHERE mail='".$email."'");
                    //J'éxecute ma requête
                    $requeteMail->execute();
                    //J'enregistre le nombre de ligne qui ressortent de la requête dans une variable countRow
                    $countRow = $requeteMail->rowCount();
                    //Si l'adresse mail ressort dans une ligne, alors l'adresse est déjà utilisée 
                    if($countRow != 0){
                        echo "Cette adresse email est déjà utilisée";
                    } else {
                        //On crypte le mot de passe
                        $mdp = hash('sha256', $mdp);
                         //On écrit les données dans la BDD 
                        $sql = $bdd->prepare("INSERT INTO individus(pseudo, mail, mot_de_passe) VALUES (:pseudo, :email, :mdp)"); 
                        $sql->bindParam("pseudo", $pseudo);
                        $sql->bindParam("email", $email); 
                        $sql->bindParam("mdp", $mdp); 
                        $sql->execute();     

                        //On autorise l'utilisateur à accéder au dashboard
                        header('location: dashboard.php');
                        exit;
                    }
           
        //Si des champs sont vides, on ne valide pas l'inscription
        } else {
            echo "Veuillez remplir tous les champs";
        }
    }
        
    ?>
</div>  
</body>
</html>

