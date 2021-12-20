<?php
namespace Foot;

class Nationales {

    private $no_equipe;

    private $pays_equipe;

    private $surnom_equipe;

    private $stade_equipe;


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

    /**
     * Get the value of surnom_equipe
     */ 
    public function getSurnom_equipe()
    {
        return $this->surnom_equipe;
    }

    /**
     * Set the value of surnom_equipe
     *
     * @return  self
     */ 
    public function setSurnom_equipe($surnom_equipe)
    {
        $this->surnom_equipe = $surnom_equipe;

        return $this;
    }

    /**
     * Get the value of stade_equipe
     */ 
    public function getStade_equipe()
    {
        return $this->stade_equipe;
    }

    /**
     * Set the value of stade_equipe
     *
     * @return  self
     */ 
    public function setStade_equipe($stade_equipe)
    {
        $this->stade_equipe = $stade_equipe;

        return $this;
    }
}
?>