<?php
namespace Foot;

class Statistiques {

    private $no_joueur;

    private $no_saison;

    private $buts;

    private $passes_decisives;

    private $cartons_jaunes;

    private $cartons_rouges;

    private $nb_matchs;

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
     * Get the value of buts
     */ 
    public function getButs()
    {
        return $this->buts;
    }

    /**
     * Set the value of buts
     *
     * @return  self
     */ 
    public function setButs($buts)
    {
        $this->buts = $buts;

        return $this;
    }

    /**
     * Get the value of passes_decisives
     */ 
    public function getPasses_decisives()
    {
        return $this->passes_decisives;
    }

    /**
     * Set the value of passes_decisives
     *
     * @return  self
     */ 
    public function setPasses_decisives($passes_decisives)
    {
        $this->passes_decisives = $passes_decisives;

        return $this;
    }

    /**
     * Get the value of cartons_jaunes
     */ 
    public function getCartons_jaunes()
    {
        return $this->cartons_jaunes;
    }

    /**
     * Set the value of cartons_jaunes
     *
     * @return  self
     */ 
    public function setCartons_jaunes($cartons_jaunes)
    {
        $this->cartons_jaunes = $cartons_jaunes;

        return $this;
    }

    /**
     * Get the value of cartons_rouges
     */ 
    public function getCartons_rouges()
    {
        return $this->cartons_rouges;
    }

    /**
     * Set the value of cartons_rouges
     *
     * @return  self
     */ 
    public function setCartons_rouges($cartons_rouges)
    {
        $this->cartons_rouges = $cartons_rouges;

        return $this;
    }

    /**
     * Get the value of nb_matchs
     */ 
    public function getNb_matchs()
    {
        return $this->nb_matchs;
    }

    /**
     * Set the value of nb_matchs
     *
     * @return  self
     */ 
    public function setNb_matchs($nb_matchs)
    {
        $this->nb_matchs = $nb_matchs;

        return $this;
    }
}
?>