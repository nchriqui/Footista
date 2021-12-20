<?php
namespace Foot;

class Joueurs {

    private $no_joueur;
    
    private $nom;
    
    private $prenom;
    
    private $date_naissance;
    
    private $numero;
    
    private $taille;

    private $nationalite;
    
    private $poste;
    
    private $pied_fort;

    private $surnom;
    
    private $no_club;
    
    private $no_equipe;


    private $nom_club;
    private $pays_equipe;


    /**
     * Get the value of no_joueur
     */ 
    public function getNo_joueur()
    {
        return $this->no_joueur;
    }

    /**
     * Set the value of no_joueur
     *
     * @return  self
     */ 
    public function setNo_joueur($no_joueur)
    {
        $this->no_joueur = $no_joueur;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of date_naissance
     */ 
    public function getDate_naissance()
    {
        return $this->date_naissance;
    }

    /**
     * Set the value of date_naissance
     *
     * @return  self
     */ 
    public function setDate_naissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of taille
     */ 
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set the value of taille
     *
     * @return  self
     */ 
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get the value of nationalite
     */ 
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set the value of nationalite
     *
     * @return  self
     */ 
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get the value of poste
     */ 
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set the value of poste
     *
     * @return  self
     */ 
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get the value of pied_fort
     */ 
    public function getPied_fort()
    {
        return $this->pied_fort;
    }

    /**
     * Set the value of pied_fort
     *
     * @return  self
     */ 
    public function setPied_fort($pied_fort)
    {
        $this->pied_fort = $pied_fort;

        return $this;
    }

    /**
     * Get the value of no_club
     */ 
    public function getNo_club()
    {
        return $this->no_club;
    }

    /**
     * Set the value of no_club
     *
     * @return  self
     */ 
    public function setNo_club($no_club)
    {
        $this->no_club = $no_club;

        return $this;
    }

    /**
     * Get the value of no_equipe
     */ 
    public function getNo_equipe()
    {
        return $this->no_equipe;
    }

    /**
     * Set the value of no_equipe
     *
     * @return  self
     */ 
    public function setNo_equipe($no_equipe)
    {
        $this->no_equipe = $no_equipe;

        return $this;
    }

    /**
     * Get the value of surnom
     */ 
    public function getSurnom()
    {
        return $this->surnom;
    }

    /**
     * Set the value of surnom
     *
     * @return  self
     */ 
    public function setSurnom($surnom)
    {
        $this->surnom = $surnom;

        return $this;
    }

    /**
     * Get the value of nom_club
     */ 
    public function getNom_club()
    {
        return $this->nom_club;
    }

    /**
     * Set the value of nom_club
     *
     * @return  self
     */ 
    public function setNom_club($nom_club)
    {
        $this->nom_club = $nom_club;

        return $this;
    }

    /**
     * Get the value of pays_equipe
     */ 
    public function getPays_equipe()
    {
        return $this->pays_equipe;
    }

    /**
     * Set the value of pays_equipe
     *
     * @return  self
     */ 
    public function setPays_equipe($pays_equipe)
    {
        $this->pays_equipe = $pays_equipe;

        return $this;
    }
}
?>