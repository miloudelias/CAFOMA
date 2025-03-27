<?php

class Inscription implements JsonSerializable {
    private $idInscription;
    private $idFormation;
    private $login;
    private $dateInscription;
    private $formation;
    
    function __construct($idFormation, $login) {
        $this->idFormation= $idFormation;
        $this->login = $login;
        $this->dateInscription = date('Y-m-d H:i:s');
    }
    
    public function __toString(): string {
        return "Inscription[idInscription=" . $this->idInscription
                . ", idFormation=" . $this->idFormation
                . ", login=" . $this->login
                . ", dateInscription=" . $this->dateInscription
                . "]";
    }
    
    #[\Override]
    public function jsonSerialize() {
        return [
            'idInscription' => $this->idInscription,
            'idFormation' => $this->idFormation,
            'login' => $this->login,
            'dateInscription' => $this->dateInscription,
            'nomFormation' => $this->formation->getNom()  
        ];
    }

    
    
    public function getIdInscription() {
        return $this->idInscription;
    }

    public function getIdFormation() {
        return $this->idFormation;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getDateInscription() {
        return $this->dateInscription;
    }

    public function getNomFormation() {
        return $this->nomFormation;
    }

    public function setIdInscription($idInscription): void {
        $this->idInscription = $idInscription;
    }

    public function setIdFormation($idFormation): void {
        $this->idFormation = $idFormation;
    }

    public function setLogin($login): void {
        $this->login = $login;
    }


    public function setDateInscription($dateInscription): void {
        $this->dateInscription = $dateInscription;
    }

    public function getFormation() {
        return $this->formation;
    }

    public function setFormation($formation): void {
        $this->formation = $formation;
    }



}
