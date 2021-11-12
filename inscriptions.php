<?php
//Inclusion de toutes les classes necessaires
require 'inclureClasse.php';



//Instanciation d'un nouvel objet PDO 
$bddPDO = new PDO('mysql:host=localhost; dbname=espace_membre', 'root','');
//Configuration attribut de gestionnaire de BDD
$bddPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Instanciation d'un nouvel objet manager
$manager = new UtilisateursManager($bddPDO);


//Une fois que le chanmp 'nom' à été saisi et que l'utilisateur a cliqué sur enregistrer, création d'un nouvel objet utilisateur, les valeurs saisies dans le formulaire seront assignées à chaque champ dans la bdd
if(isset($_POST['nom']))
{
    $utilisateur = new Utilisateurs(
        [
            'nom'=>$_POST['nom'],
            'prenom'=>$_POST['prenom'],
            'telephone'=>$_POST['telephone'],
            'mail'=>$_POST['mail']
        ]
    );

    if ($utilisateur->isUserValid())
    {
        $manager->inserer($utilisateur);

        ?>
 
        <script type="text/javascript">
         
        window.location.href='Inscriptions.php';
        alert('Utilisateur ajouté');
         
        </script>
         
        <?php
    }
    else
    {
        $erreur = $utilisateur->getErreurs();
    }
}

?>



<!DOCTYPE html>
<html>
    <head>
    <link href="inscriptions.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Inscription d'un client</title>
    </head>
    <body>

        <img src="images/background_inscription.jpg" id="img_inscription" />
        <p><a href="index.php">Accéder à l'accueil du site</a></p>

        <h1>Inscription d'un nouveau client</h1>
        <form action="Inscriptions.php" method="post">
            <div class="form-group">
                <?php if(isset($erreur) && in_array(Utilisateurs:: NOM_INVALIDE, $erreur)) 
                echo'Le nom est invalide<br>'?>
                <label for="nom">Nom</label><br>
                <input type="text"  id="nom" name="nom">
            </div>
            <div class="form-group">
                <?php if(isset($erreur) && in_array(Utilisateurs:: PRENOM_INVALIDE, $erreur)) 
                echo'Le prénom est invalide<br>'?>
                <label for="prenom">Prénom</label><br>
                <input type="text"  id="prenom" name="prenom">
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label><br>
                <input type="text"  id="telephone" name="telephone">
            </div>
            <div class="form-group">
                <?php if(isset($erreur) && in_array(Utilisateurs:: MAIL_INVALIDE, $erreur)) 
                echo'L\'adresse email est invalide<br>'?>
                <label for="mail">Email</label><br>
                <input type="email"  id="mail" name="mail">
            </div>
            <button type="submit"  class="btn btn-primary mx-auto" type="button">Enregistrer</button>
        </form>

        
    </body>
</html>