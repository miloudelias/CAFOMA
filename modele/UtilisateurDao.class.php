<?php
require_once "Utilisateur.class.php";
require_once "Connexion.class.php";

class UtilisateurDao extends Connexion {
    private static $_instance = null;
    
    private function __construct() {
    }
    
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new UtilisateurDao();
        }
        return self::$_instance;
    }
    
    function getPasswdHashUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT password FROM utilisateur WHERE login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $passwd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $passwd['password'];
    }
    
    function findAllUser(){
        $stmt = $this->getBdd()->prepare("SELECT * FROM utilisateur");
        $stmt->execute();
        $bddUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddUsers as $user){
            $u= new Utilisateur($user['login'], $user['password'], $user['mail'], $user['nom'], $user['prenom'], $user['role'], $user['image'], $user['est_valide']);
            $this->users[]=$u;
        }
        return $this->users;
    }
    
    function supprimerUser($username){
        $pdo = $this->getBdd();
        $req = "Delete from utilisateur where login = :username";
        $stmt = $pdo->prepare($req);
        $stmt = bindValue(":username", $username, PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            return true;
        } else {
            return false;
        }
    }
       
    function creerUser($user, $cle) {
        echo "user=".$user->getLogin()."<br>";
        $pdo = $this->getBdd();
        $req = "
        INSERT INTO utilisateur (login, password, mail, nom, prenom, role, image, est_valide, clef)
        values (:login, :password, :mail, :nom, :prenom, :role, :image, :est_valide, :clef)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login", $user->getLogin(), PDO::PARAM_STR);
        $stmt->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(":mail", $user->getMail(), PDO::PARAM_STR);
        $stmt->bindValue(":nom", $user->getNom(), PDO::PARAM_STR);
        $stmt->bindValue(":prenom", $user->getPrenom(), PDO::PARAM_STR);
        $stmt->bindValue(":role", $user->getRole(), PDO::PARAM_STR);
        $stmt->bindValue(":image", $user->getImage(), PDO::PARAM_STR);
        $stmt->bindValue(":est_valide", $user->getEstValide(), PDO::PARAM_STR);
        $stmt->bindValue(":clef", $cle, PDO::PARAM_STR);
        $resultat = $stmt->execute();
        
        if (!$resultat) {
            print_r($stmt->errorInfo());
        }
        
        $stmt->closeCursor();
    }
    
    function validerUser($login, $cle) {
        $pdo = $this->getBdd();
        $req = "UPDATE utilisateur SET est_valide = 1 WHERE login = :login AND clef = :cle";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->bindValue(":cle", $cle, PDO::PARAM_STR);
        $stmt->execute();
        
        /*if ($stmt->execute()) {
        echo "Requête exécutée avec succès !";
        } else {
        echo "Erreur lors de l'exécution de la requête.";
        }

        echo "Nombre de lignes modifiées : " . $stmt->rowCount();*/
        
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        if($estModifier){
            return true;
        } else {
            return false;
        }
    }
    
    function isUserValide($login){
        $pdo = $this->getBdd();
        $req = "SELECT est_valide AS isvalid FROM utilisateur WHERE login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $estValid = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return $estValid['isvalid'];
    }
    
    function isExistLoginUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT count(login) AS nb FROM utilisateur WHERE login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $nbUserTab = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return ($nbUserTab['nb'] > 0);
    }
    
    function getRoleByLogin($login){
        $pdo = $this->getBdd();
        $req = "SELECT role FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return $role['role'];
    }
    
    function findUserByLogin($login){
        $stmt = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE login=:login");
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $u=new Utilisateur($user['login'], $user['password'],$user['mail'], $user['nom'], $user['prenom'], $user['role'],$user['image'], $user['est_valide']);
        return $u;
    }
    
    function modifierUser($login, $password, $mail, $nom, $prenom, $role, $image, $est_valide) {
    $pdo = $this->getBdd();
    $req = "UPDATE utilisateur 
            SET password = :password, mail = :mail, nom = :nom, prenom = :prenom, 
                role = :role, image = :image, est_valide = :est_valide
            WHERE login = :login";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":login", $login, PDO::PARAM_STR);
    $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
    $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
    $stmt->bindValue(":role", $role, PDO::PARAM_STR);
    $stmt->bindValue(":image", $image, PDO::PARAM_STR);
    $stmt->bindValue(":est_valide", $est_valide, PDO::PARAM_INT);

    $resultat = $stmt->execute();
    $stmt->closeCursor();
    return $resultat;
    }
    
}
