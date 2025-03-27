<?php


class Ressources implements JsonSerializable {
    private $idRessource;
    private $nomFichier;
    private $typeFichier;
    private $idFormation;
    
    public function __construct($idRessource, $nomFichier, $typeFichier, $idFormation) {
        $this->idRessource = $idRessource;
        $this->nomFichier = $nomFichier;
        $this->typeFichier = $typeFichier;
        $this->idFormation = $idFormation;
    }
    
    #[\Override]
    public function jsonSerialize() {
         return [
            'idRessource' => $this->idRessource,
            'nomFichier' => $this->nomFichier,
            'typeFichier' => $this->typeFichier,
            'idFormation' => $this->idFormation
        ];
    }

    public function __toString(): string {
        return "Ressources[idRessource=" . $this->idRessource
                . ", nomFichier=" . $this->nomFichier
                . ", typeFichier=" . $this->typeFichier
                . ", idFormation=" . $this->idFormation
                . "]";
    }
    
    public function getIdRessource() {
        return $this->idRessource;
    }

    public function getNomFichier() {
        return $this->nomFichier;
    }

    public function getTypeFichier() {
        return $this->typeFichier;
    }

    public function getIdFormation() {
        return $this->idFormation;
    }

    public function setIdRessource($idRessource): void {
        $this->idRessource = $idRessource;
    }

    public function setNomFichier($nomFichier): void {
        $this->nomFichier = $nomFichier;
    }

    public function setTypeFichier($typeFichier): void {
        $this->typeFichier = $typeFichier;
    }

    public function setIdFormation($idFormation): void {
        $this->idFormation = $idFormation;
    }



}
