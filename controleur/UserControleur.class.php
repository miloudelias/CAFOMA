<?php
require_once "modele/UtilisateurDao.class.php";
require_once "modele/PartenaireDao.class.php";
require_once "outil/Securite.class.php";

class UserControleur {
    private $userDao;
    private $partenaireDao;
    
    public function __construct() {
        $this->userDao = UtilisateurDao::getInstance();
        $this->partenaireDao = PartenaireDao::getInstance();
    }
    
    function creerCompte(){
        require "vue/register.view.php";
    }
    
    function creerComptePart(){
        if(Securite::verifAccessAdmin()){
            $partenaireList = $this->partenaireDao->findAllPartenaire();
            require "vue/registerPart.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    
    function creerEtudiantValidation($login,$mail,$password, $nom, $prenom){
        $cle = uniqid();
        $this->sendMailUser($login, $mail,$cle);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "hash=".$hash."<br>";
        $user=new Utilisateur($login, $hash, $mail, $nom, $prenom, "Etudiant", "etudiant.png", 0);
        $this->userDao->creerUser($user, $cle);
        $_SESSION['message'] = "Votre compte a été créé avec succès ! Veuillez vérifier votre email pour l'activer.";
        header("Location: index.php?action=login");
    }
    
    function creerPartenaireValidation($login,$mail,$password, $nom, $prenom, $idPart){
        $cle = uniqid();
        $this->sendMailUser($login, $mail,$cle);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "hash=".$hash."<br>";
        $user=new Utilisateur($login, $hash, $mail, $nom, $prenom, "Partenaire", "partenaire.png", 0, $idPart);
        $this->userDao->creerUser($user, $cle);
        $_SESSION['message'] = "Le compte partenaire a été créé avec succès ! Veuillez vérifier l'email indiqué pour l'activer.";
        header("Location: index.php?action=administrer-utilisateur");
    }
    
    private function sendMailUser($login, $mail, $cle) {
        $urlVerification= "http://localhost/CAFOMA/index.php?action=valider-user&login=".$login."&cle=".$cle;
        $sujet = "Activation de votre compte sur CAFOMA";
        $message = "Bonjour ". $login ."\n\n Veuillez valider votre compte afin de pouvoir naviguer pleinement sur le site, cliquez sur le lien suivant : \n" .$urlVerification ."\n\n Merci!";
        Outils::sendMail($mail, $sujet, $message);
    }
    
    function recevoirMailUserValidation($login, $cle) {
        $state = $this->userDao->validerUser($login, $cle);
        
        if ($state) {
        $alert = "Votre compte a bien été validé ! Vous pouvez maintenant vous connecter.";
        } else {
        $alert = "Le lien est incorrect ou votre compte est déjà validé.";
        }
        
        require "vue/login.view.php";
        $_SESSION['message'] = "Votre compte a été activé avec succès ! Vous pouvez maintenant vous connecter.";
        header("Location: index.php?action=login");
    }
    
    function login() {
        $alert="";
        if(!Securite::isConnected()) {
            require "vue/login.view.php";
        } else {
            header("Location: index.php?action=afficher-profil");
        }  
    }
    
    function loginValidation($login, $password) {
        $alert="";
        if(!$this->userDao->isExistLoginUser($login)){
            throw new Exception("Le login n'existe pas");
        } else {
            if(isset($login) && !empty($login) 
                && isset ($password) && !empty($password)) {
                if($this->userDao->isUserValide($login)) {
                    echo "user valide";
                    echo "password=". $password ."<br>";
                    $passwdHashbd = $this->userDao->getPasswdHashUser($login);
                    echo "passwdHash bd=".$passwdHashbd."<br>";
                    if(password_verify($password, $passwdHashbd)){
                        echo "password_verify OK";  
                        $_SESSION['login'] = $login; 
                        $_SESSION['role'] = $this->userDao->getRoleByLogin($login);
                        header("Location: index.php?action=afficher-profil");
                }
                else {
                    $alert = "Mot de passe invalide";
                    require "vue/login.view.php";
                }
            }
            else {
                $alert = "Vous devez valider votre compte via votre mail";
            }
            }
            else {
            $alert = "Saisir un nom d'utilisateur et un mot de passe";
            require "vue/login.view.php";
            }
        }
    }
    
    function afficherProfil() {
        if(Securite::isConnected()) {
        $user = $this->userDao->findUserByLogin($_SESSION['login']);
        require "vue/afficherProfil.view.php";
        } else {
            throw new Exception ("Vous n'êtes pas connecté, il est donc impossible de voir votre profil");   
        }
    }
    
    function logout(){
        if(Securite::isConnected()) {
            unset($_SESSION['role']);
            unset($_SESSION['nom']);
            header("Location : index.php");
        } else{
            throw new Exception ("Vous n'êtes pas connecté, il est donc impossible de vous délogger");
        }    
    }
    
    function administrerUtilisateur(){
        if(Securite::verifAccessAdmin()){
            $users = $this->userDao->findAllUser();
            require "vue/administrerUtilisateur.view.php";
        }
        else { 
            throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
        }    
    }
    
    function supprimerCompteEtudiant() {
        if($_SESSION['role'] == 'Etudiant') {
            if(!this->inscriptionDao->isExistInscriptionByLogin($_SESSION['login'])) {
                $user = $this->userDao->supprimerUser($_SESSION['login']);
                session_unset();
                echo "session_unset()";
                require "vue/accueil.view.php";
            } else {
                throw new Exception("Impossible de supprimer votre compte car vous êtes inscrit à des formations !");
            }
        }
        else {
            require "vue/afficherProfil.view.php";
        }
    }
    
    function modifierCompte($login, $password, $mail, $nom, $prenom, $role, $image, $est_valide) {
        if (!Securite::isConnected()) {
            throw new Exception("Vous devez être connecté pour modifier votre compte.");
        }

        $user = $this->userDao->findUserByLogin($login);
        if (!$user) {
            throw new Exception("Utilisateur non trouvé.");
        }

        $success = $this->userDao->modifierUser($login, $password, $mail, $nom, $prenom, $role, $image, $est_valide);

        if ($success) {
            $_SESSION['message'] = "Le compte a été modifié avec succès.";
        } else {
            $_SESSION['message'] = "Une erreur est survenue lors de la modification.";
        }

        header("Location: index.php?action=administrer-utilisateur");
    }
    
    function modifierUser() {
        require "vue/modifierUser.view.php";
    }
    
}
