<?php
//Inclusion de toutes les classes necessaires
require 'inclureClasse.php';

//Instanciation d'un nouvel objet PDO 
$bddPDO = new PDO('mysql:host=localhost; dbname=espace_membre', 'root','');
//Configuration attribut de gestionnaire de BDD
$bddPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Instanciation d'un nouvel objet manager
$manager = new UtilisateursManager($bddPDO);


/*
Une fois que le chanmp 'nom' à été saisi et que l'utilisateur a cliqué sur enregistrer
-> création d'un nouvel objet utilisateur, les valeurs saisies dans le formulaire seront 
assignées à chaque champ dans la bdd
*/
if(isset($_POST['nom']))
{
    $utilisateur = new Utilisateurs
    (
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
            alert('L\'utilisateur a été ajouté');
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
        <!-- Lien vers ma feuille de style css 'gestion.css' -->
        <link href="inscriptions.css" rel="stylesheet">
        <!-- CDN bootstrap -->      
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Script CDN js bootstrap -->            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- Titre de l'onglet -->
        <title>Ajout d'un client</title>
    </head>
    <body>
        <header>
            <!-- Lien de retour à la page d'accueil -->
            <a href="index.php"><p class="retour_accueil">Retour à l'accueil</p></a>
            <!-- Titre de la page -->
            <h1>Ajout d'un client</h1>
        </header>

        <!-- Formulaire d'ajout d'un client -->
        <form action="inscriptions.php" method="post" class="mx-auto">
            <div class="form-group">
                <label for="nom">Nom</label><br>
                <input type="text"  id="nom" name="nom">
                <?php if(isset($erreur) && in_array(Utilisateurs:: NOM_INVALIDE, $erreur)) 
                echo'<p style="color:red;">Le nom est invalide</p><br>'?>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label><br>
                <input type="text"  id="prenom" name="prenom">
                <?php if(isset($erreur) && in_array(Utilisateurs:: PRENOM_INVALIDE, $erreur)) 
                echo'<p style="color:red;">Le prénom est invalide</p><br>'?>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label><br>
                <input type="text"  id="telephone" name="telephone">
            </div>
            <div class="form-group">
                <label for="mail">Email</label><br>
                <input type="email"  id="mail" name="mail">
                <?php if(isset($erreur) && in_array(Utilisateurs:: MAIL_INVALIDE, $erreur)) 
                echo'<p style="color:red;">L\'adresse email est invalide</p><br>'?>
            </div>
            <!-- Bouton pour valider l'ajout du nouveau client -->
            <button type="submit"  class="btn btn-primary mx-auto" id="btn_ajouter">Enregistrer</button>
        </form>
    </body>
</html>