<?php
namespace Foot\User;

use DateTime;

class User {

    private $id;

    private $username;

    private $password;

    private $mail;

    private $inscription_date;

    private $activate;

    private $code;

    private $recuperation;

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of inscription_date
     */ 
    public function getInscription_date()
    {
        return new DateTime($this->inscription_date);
    }

    /**
     * Get the value of activate
     */ 
    public function getActivate()
    {
        return (int)$this->activate;
    }

    /**
     * Set the value of activate
     *
     * @return  self
     */ 
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of recuperation
     */ 
    public function getRecuperation()
    {
        return $this->recuperation;
    }

    /**
     * Set the value of recuperation
     *
     * @return  self
     */ 
    public function setRecuperation($recuperation)
    {
        $this->recuperation = $recuperation;

        return $this;
    }
}
?>