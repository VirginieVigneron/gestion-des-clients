<?php

class Utilisateurs
{
    //Gestion des erreurs sous forme de tableau
    private $erreur=[];
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $mail;

    //Gestion des erreurs via des constantes
    const NOM_INVALIDE=1;
    const PRENOM_INVALIDE=2;
    const MAIL_INVALIDE=3;


    ////////////// Fonction qui permet de construire l'objet //////////////
    public function __construct($donnees = [])
    {
        if(!empty($donnees))
        {
        $this->hydrater($donnees);
        }
    }

    ////////////// Fonction qui fournit les données correspondant à ses attributs //////////////
    ////////////// Evite d'appeler les setters un par un dans le constructeur //////////////
    public function hydrater($donnees = [])
    {
        foreach ($donnees as $attribut => $valeur)
        {
            $methodeSetters = 'set'.ucfirst($attribut);
            $this->$methodeSetters($valeur);
        }
    }

    ////////////// Setters qui permettent de changer la valeur d'un attribut //////////////
    public function setId($id)
    {
        /*
        Si la variable passée en paramètres n'est pas vide, on affecte à l'attribut 'id' 
        la valeur de cette variable en forçant le typage en 'int'
        */
        if(!empty($id))
        {
            $this->id = (int)$id;
        }
    }

    public function setNom($nom)
    {
        /*
        Vérifie si la variable n'est pas une chaîne de caractère ou est vide-> on affecte 
        dans le tableau 'erreur' la constante 'NOM_INVALIDE'
        */
        if(!is_string($nom) || empty($nom))
        {
            $this->erreur[] = self::NOM_INVALIDE;
        }
        else
        {
            $this->nom = $nom;
        }
    }

    public function setPrenom($prenom)
    {
        /*
        Vérifie si la variable n'est pas une chaîne de caractère ou est vide 
        -> on affecte dans le tableau 'erreur' la constante 'PRENOM_INVALIDE'
        */
        if(!is_string($prenom) || empty($prenom))
        {
            $this->erreur[] = self::PRENOM_INVALIDE;
        }
        else
        {
            $this->prenom = $prenom;
        }
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function setMail($mail)
    {
        /*
        Vérifie la synthaxe de l'adresse email avec une foncion native, si incorrect 
        -> on affecte dans le tableau 'erreur' la constante 'PRENOM_INVALIDE'
        */
        if(filter_var($mail,FILTER_VALIDATE_EMAIL))
        {
            $this->mail = $mail;
        }
        else
        {
            $this->erreur[] = self::MAIL_INVALIDE;
        }

    }

    ////////////// Getters qui permettent de récupérer les données //////////////
    public function getId()
    {
        return $this->id;
    }
    
    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    
    public function getMail()
    {
        return $this->mail;
    }

    public function getErreurs()
    {
        return $this->erreur;
    }

    ////////////// Fonction qui vérifie que l'utilisateur est valide (nom + prénom + mail), va retourner vrai si ils ne sont pas vide et false dans le cas contraire //////////////
    public function isUserValid()
    {
        return !( empty($this->nom) || empty($this->prenom) || empty($this->mail) );
    }
}