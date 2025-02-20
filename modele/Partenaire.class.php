<?php


class Partenaire implements JsonSerializable {
    private $idPart;
    private $nom;
    private $description;
    
    function __construct($nom, $description) {
        $this->nom = $nom;
        $this->description = $description;
    }
    
     public function __toString() {
        return "Partenaire[idPart=" . $this->idPart
                . ", nom=" . $this->nom
                . ", description=" . $this->description
                . "]";
    }

    #[\Override]
    public function jsonSerialize(){
        return[
            'id' => $this->idPart,
            'nom' => $this->nom,
            'description' => $this->description
        ];
    }

    public function getIdPart() {
        return $this->idPart;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setIdPart($idPart): void {
        $this->idPart = $idPart;
    }

    public function setNom($nom): void {
        $this->nom = $nom;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }


    
}
