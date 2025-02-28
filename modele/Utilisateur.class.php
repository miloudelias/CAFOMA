<?php

class Utilisateur {
    private $login;
    private $password;
    private $mail;
    private $nom;
    private $prenom;
    private $role;
    private $image;
    private $estValide;
    
    function __construct($login, $password, $mail, $nom, $prenom, $role, $image, $estValide) {
        $this->login = $login;
        $this->password = $password;
        $this->mail = $mail;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->image = $image;
        $this->estValide = $estValide;
    }
    
    public function __toString(): string {
        return "Utilisateur[login=" . $this->login
                . ", password=" . $this->password
                . ", mail=" . $this->mail
                . ", nom=" . $this->nom
                . ", prenom=" . $this->prenom
                . ", role=" . $this->role
                . ", image=" . $this->image
                . ", estValide=" . $this->estValide
                . "]";
    }
    
    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getMail() {
        return $this->mail;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getPrenom() {
        return $this->prenom;
    }

    public function getRole() {
        return $this->role;
    }

    public function getImage() {
        return $this->image;
    }

    public function getEstValide() {
        return $this->estValide;
    }

    public function setLogin($login): void {
        $this->login = $login;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setMail($mail): void {
        $this->mail = $mail;
    }
    
    public function setNom($nom): void {
        $this->nom = $nom;
    }
    
    public function setPrenom($prenom): void {
        $this->prenom = $prenom;
    }

    public function setRole($role): void {
        $this->role = $role;
    }

    public function setImage($image): void {
        $this->image = $image;
    }

    public function setEstValide($estValide): void {
        $this->estValide = $estValide;
    }



}
