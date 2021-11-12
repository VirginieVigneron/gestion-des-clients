<?php

class UtilisateursManager
{
    private $bddPDO;


    //Initie la connexion à la base de données
    public function __construct(PDO $bddPDO)
    {
        $this->bddPDO = $bddPDO;
    }

    //Insérer les données récupérées du formulaire dans la BDD
    public function inserer(Utilisateurs $utilisateur)
    {
        $requete = $this->bddPDO->prepare('INSERT INTO utilisateurs(nom, prenom, telephone, mail) VALUES(:nom,:prenom,:telephone,:mail)');

        //Permet de faire la correspondance entre les marqueurs et la valeur que l'on veut donner à ce marqueur
        $requete->bindValue(':nom', $utilisateur->getNom());
        $requete->bindValue(':prenom', $utilisateur->getPrenom());
        $requete->bindValue(':telephone', $utilisateur->getTelephone());
        $requete->bindValue(':mail', $utilisateur->getMail());

        //Execution de cette requête
        $requete->execute();
    }

    //Fonction qui permet de récupérer tous les utilisateurs de la bdd
    public function getListeUtilisateurs()
    {
        $requete = $this->bddPDO->query('SELECT * FROM espace_membre.utilisateurs ORDER BY nom ASC');

        //setFetchMode: spécifie le mode de récupération de la requête
        //FETCH_CLASS: retourne une nouvelle instance de la classe demandée
        //FETCH_PROPS_LATE: indique que le constructeur doit etre appelé avant que les attributs soient assignés par le PDO pour éviter qu'il les écrase
        $requete->setFetchMode(PDO::FETCH_CLASS | PDO:: FETCH_PROPS_LATE, 'utilisateurs');

        //Récupérer dans un tableau toutes les lignes de la table utilisateur
        $listeUtilisateurs = $requete->fetchAll();

        //Fermeture de la requête
        $requete->closeCursor();

        return $listeUtilisateurs;
    }

    //Fonction qui permet de ne récupérer qu'un utilisateur par son id
    public function getUtilisateur($id)
    {
        $requete = $this->bddPDO->prepare('SELECT * FROM utilisateurs WHERE id=:id');

        $requete->bindValue(':id', (int) $id, PDO::PARAM_INT);

        $requete->execute();

        $requete->setFetchMode(PDO::FETCH_CLASS | PDO:: FETCH_PROPS_LATE, 'utilisateurs');

        $utilisateur = $requete->fetch();

        return $utilisateur;

    }

    public function mettreAjour(Utilisateurs $utilisateur)
    {
        $requete = $this->bddPDO->prepare('UPDATE espace_membre.utilisateurs SET nom=:nom, prenom=:prenom, telephone=:telephone, mail=:mail WHERE id=:id');

        $requete->bindValue(':id', $utilisateur->getId(), PDO::PARAM_INT);

        $requete->bindValue(':nom', $utilisateur->getNom());
        $requete->bindValue(':prenom', $utilisateur->getPrenom());
        $requete->bindValue(':telephone', $utilisateur->getTelephone());
        $requete->bindValue(':mail', $utilisateur->getMail());

        $requete->execute();

    }

    public function supprimer($id)
    {
        $this->bddPDO->exec('DELETE FROM espace_membre.utilisateurs WHERE id='.(int)$id);
    }
}