<?php
namespace Foot;

class Trophees {

    private $no_tr;

    private $nom_tr;

    private $description;

    private $type_tr;

    private $no_compet;

    private $no_saison;

    private $no_club;

    private $no_equipe;

    private $no_joueur;

    /**
     * Get the value of no_tr
     */ 
    public function getNo_tr()
    {
        return $this->no_tr;
    }

    /**
     * Set the value of no_tr
     *
     * @return  self
     */ 
    public function setNo_tr($no_tr)
    {
        $this->no_tr = $no_tr;

        return $this;
    }

    /**
     * Get the value of nom_tr
     */ 
    public function getNom_tr()
    {
        return $this->nom_tr;
    }

    /**
     * Set the value of nom_tr
     *
     * @return  self
     */ 
    public function setNom_tr($nom_tr)
    {
        $this->nom_tr = $nom_tr;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type_tr
     */ 
    public function getType_tr()
    {
        return $this->type_tr;
    }

    /**
     * Set the value of type_tr
     *
     * @return  self
     */ 
    public function setType_tr($type_tr)
    {
        $this->type_tr = $type_tr;

        return $this;
    }

    /**
     * Get the value of no_compet
     */ 
    public function getNo_compet()
    {
        return $this->no_compet;
    }

    /**
     * Set the value of no_compet
     *
     * @return  self
     */ 
    public function setNo_compet($no_compet)
    {
        $this->no_compet = $no_compet;

        return $this;
    }

    /**
     * Get the value of no_saison
     */ 
    public function getNo_saison()
    {
        return $this->no_saison;
    }

    /**
     * Set the value of no_saison
     *
     * @return  self
     */ 
    public function setNo_saison($no_saison)
    {
        $this->no_saison = $no_saison;

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
    
}
?>