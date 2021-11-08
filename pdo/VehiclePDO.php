<?php

require_once realpath('conf/SqlConnector.php');
spl_autoload_register(function(){
  require_once realpath('class/Vehicle.php');
});



define('ATTR_VEHICLEPDO',"id,name,idType");
function convertRowToVehicleClass($r){
    return new Vehicle($r['id'],$r['name'],$r['idType']);
}

function readVehicleById($id){
    $sql = "SELECT ".ATTR_VEHICLEPDO." FROM vehicle WHERE id='$id'";
    $return = selectSimple($sql,'convertRowToVehicleClass');
    
    return $return;
}



function readVehicleByIdType($idType){

    $sql = "SELECT ".ATTR_VEHICLEPDO." FROM vehicle WHERE idType='$idType'";
    $return = selectMultiple($sql,'convertRowToVehicleClass','id');
    
    return $return;  
}



function createVehicle($vehicle,$idPanel){
    
    $pass = false;
     
    execSql("INSERT INTO vehicle VALUES('','".$vehicle->getNamr()."','".$vehicle->getIdType()."')");
    
    $pass = true;

    return $pass;
}


function updateVehicle($vehicle){

    execSql("UPDATE vehicle SET name='".$vehicle->getName()."' WHERE id='".$vehicle->getId()."'");
    $pass = true;

    return $pass;
}




function removeVehicle($idVehicle){
    
    $pass = false;
    execSql("DELETE FROM vehicle WHERE id='$idVehicle'")
    
    $pass = true; 
     
    
    return $pass;
}
