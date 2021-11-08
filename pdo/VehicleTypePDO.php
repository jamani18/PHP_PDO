<?php

require_once realpath('conf/SqlConnector.php');
spl_autoload_register(function(){
  require_once realpath('class/VehicleType.php');
});



define('ATTR_VEHICLETYPEPDO',"id,name");
function convertRowToVehicleTypeClass($r){
    return new VehicleType($r['id'],$r['name']);
}

function readVehicleTypeById($id){
    $sql = "SELECT ".ATTR_VEHICLETYPEPDO." FROM vehicletype WHERE id='$id'";
    $return = selectSimple($sql,'convertRowToVehicleTypeClass');
    
    return $return;
}

