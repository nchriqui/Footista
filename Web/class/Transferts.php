<?php
namespace Foot;

class Transferts {

    private $no_transfert;

    private $montant;

    private $date_transfert;

    private $no_joueur;

    private $no_club_depart;

    private $no_club_arrivee;

    /**
     * Get the value of no_transfert
     */ 
    public function getNo_transfert()
    {
        return $this->no_transfert;
    }

    /**
     * Set the value of no_transfert
     *
     * @return  self
     */ 
    public function setNo_transfert($no_transfert)
    {
        $this->no_transfert = $no_transfert;

        return $this;
    }

    /**
     * Get the value of montant
     */ 
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */ 
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of date_transfert
     */ 
    public function getDate_transfert()
    {
        return $this->date_transfert;
    }

    /**
     * Set the value of date_transfert
     *
     * @return  self
     */ 
    public function setDate_transfert($date_transfert)
    {
        $this->date_transfert = $date_transfert;

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

    /**
     * Get the value of no_club_depart
     */ 
    public function getNo_club_depart()
    {
        return $this->no_club_depart;
    }

    /**
     * Set the value of no_club_depart
     *
     * @return  self
     */ 
    public function setNo_club_depart($no_club_depart)
    {
        $this->no_club_depart = $no_club_depart;

        return $this;
    }

    /**
     * Get the value of no_club_arrivee
     */ 
    public function getNo_club_arrivee()
    {
        return $this->no_club_arrivee;
    }

    /**
     * Set the value of no_club_arrivee
     *
     * @return  self
     */ 
    public function setNo_club_arrivee($no_club_arrivee)
    {
        $this->no_club_arrivee = $no_club_arrivee;

        return $this;
    }
}
?>