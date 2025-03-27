<?php

class Formation implements JsonSerializable {
    private $id;
    private $nom;
    private $type;
    private $description;
    private $contenu;
    private $duree;
    private $niveau;
    private $mode;
    private $image;
    //private $fichiers;
    private $ressources;
    private $partenaire;
   
    
    public function __construct($id, $nom, $type, $description, $contenu, $duree, $niveau, $mode, $image, $ressources = []) {
        $this->id = $id;
        $this->nom = $nom;
        $this->type = $type;
        $this->description = $description;
        $this->contenu = $contenu;
        $this->duree = $duree;
        $this->niveau = $niveau;
        $this->mode = $mode;
        $this->image = $image;
        //$this->fichiers = $fichiers;
        $this->ressources = $ressources;
    }
    
    public function __toString(): string {
        return "Formation[id=" . $this->id
                . ", nom=" . $this->nom
                .", type=" . $this->type
                . ", description=" . $this->description
                . ", contenu=" . $this->contenu
                . ", duree=" . $this->duree
                . ", niveau=" . $this->niveau
                . ", mode=" . $this->mode
                . ", image=" . $this->image
                //. ", fichiers=" . $this->fichiers
                . ", ressources=" . $this->ressources
                . ", partenaire=" . $this->partenaire->getNom()
                . "]";
    }

    
    public function jsonSerialize(){
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'type' => $this->type,
            'description' => $this->description,
            'contenu' => $this->contenu,
            'duree' => $this->duree,
            'niveau' => $this->niveau,
            'mode' => $this->mode,
            'image' => $this->image,
            //'fichiers' => $this->fichiers,
            'ressources' => $this->ressources,
            'nomPartenaire' => $this->partenaire->getNom(),
            'idPart' => $this->partenaire->getIdPartenaire()        
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
    
    public function getContenu() {
        return $this->contenu;
    }

    /*public function getFichiers() {
        return $this->fichiers;
    }*/

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

    /*public function setFichiers($fichiers){
        $this->fichiers = $fichiers;
    }*/
    
    public function setContenu ($contenu) {
        $this->contenu = $contenu;
    }

    public function setPartenaire($partenaire) {
        $this->partenaire = $partenaire;
    }

    public function getDuree() {
        return $this->duree;
    }

    public function getNiveau() {
        return $this->niveau;
    }

    public function getMode() {
        return $this->mode;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
    }

    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }

    public function setMode($mode) {
        $this->mode = $mode;
    }

    public function getRessources() {
        return $this->ressources;
    }

    public function setRessources($ressources){
        $this->ressources = $ressources;
    }



}
