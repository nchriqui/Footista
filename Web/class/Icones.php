<?php
namespace Foot;

class Icones {

    private $no_joueur_icone;

    private $debut_carriere;

    private $fin_carriere;

    private $profession_actuelle;

    private $moment_memorable;

    private $decede;

    private $date_deces;


    /**
     * Get the value of no_joueur_icone
     */ 
    public function getNo_joueur_icone()
    {
        return $this->no_joueur_icone;
    }

    /**
     * Set the value of no_joueur_icone
     *
     * @return  self
     */ 
    public function setNo_joueur_icone($no_joueur_icone)
    {
        $this->no_joueur_icone = $no_joueur_icone;

        return $this;
    }

    /**
     * Get the value of debut_carriere
     */ 
    public function getDebut_carriere()
    {
        return $this->debut_carriere;
    }

    /**
     * Set the value of debut_carriere
     *
     * @return  self
     */ 
    public function setDebut_carriere($debut_carriere)
    {
        $this->debut_carriere = $debut_carriere;

        return $this;
    }

    /**
     * Get the value of fin_carriere
     */ 
    public function getFin_carriere()
    {
        return $this->fin_carriere;
    }

    /**
     * Set the value of fin_carriere
     *
     * @return  self
     */ 
    public function setFin_carriere($fin_carriere)
    {
        $this->fin_carriere = $fin_carriere;

        return $this;
    }

    /**
     * Get the value of profession_actuelle
     */ 
    public function getProfession_actuelle()
    {
        return $this->profession_actuelle;
    }

    /**
     * Set the value of profession_actuelle
     *
     * @return  self
     */ 
    public function setProfession_actuelle($profession_actuelle)
    {
        $this->profession_actuelle = $profession_actuelle;

        return $this;
    }

    /**
     * Get the value of moment_memorable
     */ 
    public function getMoment_memorable()
    {
        return $this->moment_memorable;
    }

    /**
     * Set the value of moment_memorable
     *
     * @return  self
     */ 
    public function setMoment_memorable($moment_memorable)
    {
        $this->moment_memorable = $moment_memorable;

        return $this;
    }

    /**
     * Get the value of decede
     */ 
    public function getDecede()
    {
        return $this->decede;
    }

    /**
     * Set the value of decede
     *
     * @return  self
     */ 
    public function setDecede($decede)
    {
        $this->decede = $decede;

        return $this;
    }

    /**
     * Get the value of date_deces
     */ 
    public function getDate_deces()
    {
        return $this->date_deces;
    }

    /**
     * Set the value of date_deces
     *
     * @return  self
     */ 
    public function setDate_deces($date_deces)
    {
        $this->date_deces = $date_deces;

        return $this;
    }
}
?>