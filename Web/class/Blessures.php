<?php
namespace Foot;

class Blessures {

    private $no_blessure;

    private $date_debut_blessure;

    private $nom_blessure;

    private $date_fin_blessure;

    private $no_joueur;

    /**
     * Get the value of no_blessure
     */ 
    public function getNo_blessure()
    {
        return $this->no_blessure;
    }

    /**
     * Set the value of no_blessure
     *
     * @return  self
     */ 
    public function setNo_blessure($no_blessure)
    {
        $this->no_blessure = $no_blessure;

        return $this;
    }

    /**
     * Get the value of date_debut_blessure
     */ 
    public function getDate_debut_blessure()
    {
        return $this->date_debut_blessure;
    }

    /**
     * Set the value of date_debut_blessure
     *
     * @return  self
     */ 
    public function setDate_debut_blessure($date_debut_blessure)
    {
        $this->date_debut_blessure = $date_debut_blessure;

        return $this;
    }

    /**
     * Get the value of nom_blessure
     */ 
    public function getNom_blessure()
    {
        return $this->nom_blessure;
    }

    /**
     * Set the value of nom_blessure
     *
     * @return  self
     */ 
    public function setNom_blessure($nom_blessure)
    {
        $this->nom_blessure = $nom_blessure;

        return $this;
    }

    /**
     * Get the value of date_fin_blessure
     */ 
    public function getDate_fin_blessure()
    {
        return $this->date_fin_blessure;
    }

    /**
     * Set the value of date_fin_blessure
     *
     * @return  self
     */ 
    public function setDate_fin_blessure($date_fin_blessure)
    {
        $this->date_fin_blessure = $date_fin_blessure;

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