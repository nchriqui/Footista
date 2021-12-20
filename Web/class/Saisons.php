<?php
namespace Foot;

class Saisons {

    private $no_saison;

    private $date_debut;

    private $date_fin;

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
     * Get the value of date_debut
     */ 
    public function getDate_debut()
    {
        return $this->date_debut;
    }

    /**
     * Set the value of date_debut
     *
     * @return  self
     */ 
    public function setDate_debut($date_debut)
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    /**
     * Get the value of date_fin
     */ 
    public function getDate_fin()
    {
        return $this->date_fin;
    }

    /**
     * Set the value of date_fin
     *
     * @return  self
     */ 
    public function setDate_fin($date_fin)
    {
        $this->date_fin = $date_fin;

        return $this;
    }
}
?>