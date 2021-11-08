# PHP_PDO
Structure to connect classes with the data stored in the database

## Install

**Manual**

Just download php/SqlConnector file, and include or require php/SqlConnector on your PHP file:

```php
require_once 'SqlConnector.php';
```

## Requirements

**Server**

Only need a PHP server with version 7 minimum.

## Start up

Open the SqlConnector.php file and modify the values of the connection data to the database so that it connects.

For more information, see SqlConnector repository: https://github.com/jamani18/SqlConnector

## Usage

This structure is divided into two components:

1. Class that will have the necessary attributes and that will correspond to a table in the database. Usually it should match all the fields.
2. PDO file where the connections with the database will be made. This component will also allow to transform the data obtained in an instance of the nested class.

### PDO Structure.

The components to be declared for correct operation and examples of some of the methods used by the queries are detailed below.

**0. Nomenclature**

By convention, the file name must be the class name + PDO.

For example:

_For class Vehicle, we call the file: VehiclePDO.php_

It is recommended to include these files in a directory called 'pdo'.


**1. Nest the class**

We must include in the file the class with which it will work together with SqlConnector.php.

```php

require_once realpath('conf/SqlConnector.php');
spl_autoload_register(function(){
  require_once realpath('class/Vehicle.php');
});

````

**2. Store table fields**

To create the sentences more comfortably, we store the name of the table fields in a global variable


```php

define('ATTR_VEHICLEPDO',"id,name,idType");

````

**3. Create handler to pass from array to class instance**

We create a method that will be passed a row in the database as a parameter and that will return an instance of the class we are working with.

```php

function convertRowToVehicleClass($r){
    return new Vehicle($r['id'],$r['name'],$r['idType']);
}

````

**4. Establish communications with the database**

Using the SqlConnector.php file, we perform the CRUD with the database.

Here are some examples of the code.

```php

//VehiclePDO.php

function readVehicleById($id){
    $return = selectSimple("SELECT ".ATTR_VEHICLEPDO." FROM vehicle WHERE id='$id'",'convertRowToVehicleClass');
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


````

### Class structure

Next, the steps to form the class with the attributes are established. Taking care of the peculiar case that the class houses other instances of classes as attributes.

To start, we create the primitive type attributes as they are normally done and then we create the constructor.

```php

class Vehicle {
    
    protected $id;
    protected $name;
    protected $idType;
    
    function __construct($id, $name,$idType) {
        $this->id = $id;
        $this->name = $name;
        $this->idType = $idType;
    }
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }
    
    ........


````

We pay attention to the structure to set attributes of class instances. In this case we do it with $ type.

To do this, we start by declaring the attribute that stores the ID of the foreign key ($ idType) and an attribute where the instance will be stored with a default NULL value ($ type).

In this example we use the Vehicle.php file that will have a VehicleType inside.

```php

//Vehicle.php
protected $idType; //foraign key
protected $type = NULL; //object

function __construct($id, $name,$idType) {} //just pass foraign key on construct.

````

The getters and setters for both $idType and $type will have the following structure:

```php

//Vehicle.php

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

````

With this structure we manage to obtain the object from the database the first time, and once obtained, it will only query it in the same class.

