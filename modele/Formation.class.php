<?php

class Formation implements JsonSerializable {
    private $id;
    private $nom;
    private $description;
    private $image;
    private $fichiers;
    private $partenaire;
    
    public function __construct($id, $nom, $description, $type, $image, $fichiers) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->image = $image;
        $this->fichiers = $fichiers;
    }
    
    public function __toString(): string {
        return "Formation[id=" . $this->id
                . ", nom=" . $this->nom
                . ", description=" . $this->description
                .", type=" . $this->type
                . ", image=" . $this->image
                . ", fichiers=" . $this->fichiers
                . "]";
    }

    
    public function jsonSerialize(){
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'type' => $this->type,
            'image' => $this->image,
            'fichiers' => $this->fichiers,
            'nomPartenaire' => $this->partenaire->getNom(),
            'idPart' => $this->partenaire->getIdPart()
                
        ];
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function getType() {
        return $this->type;
    }

    public function getImage() {
        return $this->image;
    }

    public function getFichiers() {
        return $this->fichiers;
    }

    public function getPartenaire() {
        return $this->partenaire;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setDescription($description){
        $this->description = $description;
    }
    
    public function setType($type){
        $this->type = $type;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function setFichiers($fichiers){
        $this->fichiers = $fichiers;
    }

    public function setPartenaire($partenaire): void {
        $this->partenaire = $partenaire;
    }



}
