<?php

class Vehicle {
    
    protected $id;
    protected $name;
    protected $idType;
    
    protected $type = NULL;

    function __construct($id, $name,$idType) {
        $this->id = $id;
        $this->name = $name;
        $this->idType = $idType;
    }
    

 //get $idType
function getIdType() {
    return $this->idType;
}

//set an $idType and reset $type saved.
function setIdType($idType) {
    $this->idType = $idType;
    $this->type = NULL;
}

//get the type of vehicle. If is the first time, we search on database, else we get from attribute.
function getType() {
    $this->type === NULL ? $this->type = readVehicleTypeById($this->idType) : false;
    return $this->type;
}

//set an a type of vehicle object. Update the $idType value.
function setType($type) {
    $this->type = $type ? $type : NULL;
    $this->idType = $type ? $type->getId() : false;
}
    
   
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }



    function setId($id) {
        $this->id = $id;
    }


    function setName($name) {
        $this->name = $name;
    }

}
