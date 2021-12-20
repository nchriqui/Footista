<?php
namespace Foot;

class Clubs {

    private $no_club;

    private $nom_club;

    private $pays_club;

    private $stade_club;

    private $surnom_club;
    

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
     * Get the value of pays_club
     */ 
    public function getPays_club()
    {
        return $this->pays_club;
    }

    /**
     * Set the value of pays_club
     *
     * @return  self
     */ 
    public function setPays_club($pays_club)
    {
        $this->pays_club = $pays_club;

        return $this;
    }

    /**
     * Get the value of stade_club
     */ 
    public function getStade_club()
    {
        return $this->stade_club;
    }

    /**
     * Set the value of stade_club
     *
     * @return  self
     */ 
    public function setStade_club($stade_club)
    {
        $this->stade_club = $stade_club;

        return $this;
    }

    /**
     * Get the value of surnom_club
     */ 
    public function getSurnom_club()
    {
        return $this->surnom_club;
    }

    /**
     * Set the value of surnom_club
     *
     * @return  self
     */ 
    public function setSurnom_club($surnom_club)
    {
        $this->surnom_club = $surnom_club;

        return $this;
    }
}
?>