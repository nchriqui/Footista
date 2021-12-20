<?php
namespace Foot;

class Competitions {

    private $no_compet;

    private $nom_compet;

    private $pays_compet;

    private $organisateur;

    private $type_compet;

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
     * Get the value of nom_compet
     */ 
    public function getNom_compet()
    {
        return $this->nom_compet;
    }

    /**
     * Set the value of nom_compet
     *
     * @return  self
     */ 
    public function setNom_compet($nom_compet)
    {
        $this->nom_compet = $nom_compet;

        return $this;
    }

    /**
     * Get the value of pays_compet
     */ 
    public function getPays_compet()
    {
        return $this->pays_compet;
    }

    /**
     * Set the value of pays_compet
     *
     * @return  self
     */ 
    public function setPays_compet($pays_compet)
    {
        $this->pays_compet = $pays_compet;

        return $this;
    }

    /**
     * Get the value of organisateur
     */ 
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * Set the value of organisateur
     *
     * @return  self
     */ 
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * Get the value of type_compet
     */ 
    public function getType_compet()
    {
        return $this->type_compet;
    }

    /**
     * Set the value of type_compet
     *
     * @return  self
     */ 
    public function setType_compet($type_compet)
    {
        $this->type_compet = $type_compet;

        return $this;
    }
}
?>