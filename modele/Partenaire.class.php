<?php


class Partenaire implements JsonSerializable {
    private $idPartenaire;
    private $nom;
    private $description;
    
    function __construct($nom, $description) {
        $this->nom = $nom;
        $this->description = $description;
    }
    
     public function __toString() {
        return "Partenaire[idPartenaire=" . $this->idPartenaire
                . ", nom=" . $this->nom
                . ", description=" . $this->description
                . "]";
    }

    #[\Override]
    public function jsonSerialize(){
        return[
            'id' => $this->idPartenaire,
            'nom' => $this->nom,
            'description' => $this->description
        ];
    }

    public function getIdPartenaire() {
        return $this->idPartenaire;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setIdPartenaire($idPartenaire): void {
        $this->idPartenaire = $idPartenaire;
    }

    public function setNom($nom): void {
        $this->nom = $nom;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }


    
}
