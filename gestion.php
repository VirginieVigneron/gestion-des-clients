<?php

//Inclusion de toutes les classes nécessaires
require 'inclureClasse.php';

//Instanciation d'un nouvel objet PDO 
$bddPDO = new PDO('mysql:host=localhost; dbname=espace_membre', 'root','');
//Configuration attribut de gestionnaire de BDD
$bddPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//Instanciation d'un nouvel objet manager
$manager = new UtilisateursManager($bddPDO);


if(isset($_GET['modifier']))
{
    $utilisateur = $manager->getUtilisateur((int) $_GET['modifier']);
}


if(isset($_POST['nom']))
{
    $utilisateur = new Utilisateurs
    (
        [
            'nom'=> $_POST['nom'],
            'prenom'=> $_POST['prenom'],
            'telephone'=> $_POST['telephone'],
            'mail'=> $_POST['mail']
        ]
    );

    if(isset($_POST['id']))
    {
        $utilisateur->setId($_POST['id']);
    }

    if($utilisateur->isUserValid())
    {
        $manager->mettreAjour($utilisateur);
        ?>
 
        <script type="text/javascript">
         
        window.location.href='gestion.php';
        alert('Utilisateur modifié');
         
        </script>
         
        <?php
    }
    else
    {
        $erreur = $utilisateur->getErreurs();
    }
}


if(isset($_GET['supprimer']))
{
    $manager->supprimer((int) $_GET['supprimer']);
    ?>
 
        <script type="text/javascript">
         
        window.location.href='gestion.php';
        alert('L\'utilisateur a été supprimé');
         
        </script>
         
        <?php
}
?>


<!DOCTYPE html>
<html>
    <head>
        <!-- Lien vers ma feuille de style css 'gestion.css' -->
        <link href="gestion.css" rel="stylesheet">
        <!-- CDN bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Script CDN js bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- Titre de l'onglet -->
        <title>Gestion clientèle</title>
        <meta charset="utf-8" />        
    </head>

    <body>
        <header>
            <!-- Lien de retour à la page d'accueil -->
            <a href="index.php"><p class="retour_accueil">Retour à l'accueil</p></a>
            <!-- Titre de la page -->
            <h1>Modification d'un client</h1>
        </header>

        <!-- Formulaire de modification d'un client selectionné -->
        <form action="gestion.php" method="post">
            <div class="form-group">
                <?php if(isset($erreur) && in_array(Utilisateurs:: NOM_INVALIDE, $erreur)) 
                echo'Le nom est invalide<br>'?>
                <label for="nom">Nom</label><br>
                <input type="text" name="nom" value="<?php if(isset($utilisateur))echo $utilisateur->getNom();?>">
            </div>
            <div class="form-group">
                <?php if(isset($erreur) && in_array(Utilisateurs:: PRENOM_INVALIDE, $erreur)) 
                echo'Le prénom est invalide<br>'?>
                <label for="prenom">Prénom</label><br>
                <input type="text" name="prenom" value="<?php if(isset($utilisateur))echo $utilisateur->getPrenom();?>">
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label><br>
                <input type="text" name="telephone" value="<?php if(isset($utilisateur))echo $utilisateur->getTelephone();?>">
            </div>
            <div class="form-group">
                <?php if(isset($erreur) && in_array(Utilisateurs:: MAIL_INVALIDE, $erreur)) 
                echo'L\'adresse email est invalide<br>'?>
                <label for="mail">Email</label><br>
                <input type="text" name="mail" value="<?php if(isset($utilisateur))echo $utilisateur->getMail();?>">
            </div>
            <?php
            if(isset($utilisateur))
            {
                ?>
                <input type="hidden" name="id" value="<?=$utilisateur->getId() ?>" />
                <?php
            }
            ?>
            <!-- Bouton pour valider la modification apportée -->
            <button type="submit" name="Modifier" class="btn btn-primary mx-auto" id="btn_modifier" >Modifier</button>
        </form>

        <!-- Tableau de présentation des clients -->
        <table class="tableau-style">
            <?php
            if(isset($message))
            {
                echo $message;
            }
            echo '<br><br>';
            ?>

            <!-- En-tête du tableau -->
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Mail</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>

            <!-- Boucle sur chaque élément du tableau -->
            <?php 
            foreach($manager->getListeUtilisateurs() as $utilisateur)
            {
                echo 
                '<tbody>
                    <tr>
                        <td>', $utilisateur->getNom(),'</td>
                        <td>', $utilisateur->getPrenom(),'</td>
                        <td>', $utilisateur->getTelephone(),'</td>
                        <td>', $utilisateur->getMail(),'</td>
                        <td><a href="?modifier=',$utilisateur->getId(),'"><img src="images/icons/pencil.svg" alt="Bootstrap"></a></td>
                        <td><a href="?supprimer=',$utilisateur->getId(),'"><img src="images/icons/trash.svg" alt="Bootstrap"></a></td>
                    </tr>
                </tbody>';
            }
            ?>
        </table>
    </body>
</html>