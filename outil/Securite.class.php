<?php

/**
 * Description of Securite
 *
 * @author elias
 */

class Securite {
    public static function verifAccessAdmin(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "Admin");
    }
    public static function verifAccessPartenaire(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "Partenaire");
    }
    public static function verifAccessEtudiant(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "Etudiant");
    }
    public static function isConnected(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']));
    }
}
