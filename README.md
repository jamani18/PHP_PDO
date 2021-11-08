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

Esta estructura se divide en dos componentes:

1. Clase que tendrá los atributos necesarios y que corresponderá a una tabla de la base de datos. Usualmente deberá coincidir con todos los campos.
2. Fichero PDO donde se realizarán las conexiones con la base de datos. Este componente permitirá además transformar los datos obtenidos en instancia de la clase anidada.

### Estructura del PDO.

A continuación se detalla los componentes a declarar para el correcto funcionamiento y ejemplos de algunos de los métodos que realizan las consultas.

**0. Nomenclatura**
Por convenio, el nombre del fichero deberá ser el nombre de la clase + PDO. 

For example:

_For class Vehicle, we call the file: VehiclePDO.php_

Recomendado incluir estos ficheros en un directorio llamado 'pdo'.


**1. Anidar la clase**
Debemos incluir en el fichero la clase con la que trabajará junto con SqlConnector.php.

```php

require_once realpath('conf/SqlConnector.php');
spl_autoload_register(function(){
  require_once realpath('class/Vehicle.php');
});

````

**2. Almacenar los campos de la tabla**

Para crear las sentencias de forma más cómoda en un futuro, almacenamos el nombre de los campos de la tabla en una variable global


```php

define('ATTR_VEHICLEPDO',"id,name,idType");

````

Recommended if we know in advance that the query only returns one row.

```php
/**
* Get the first result from SELECT sentence on array.
* @param $sql SELECT sentence
* @return the row on associative array.
*/       
selectSimpleResult($sql);
//Example
$result = selectSimpleResult("SELECT name FROM client WHERE id='23'");
/*Inspect 
  //$result
  //array("name" => "John");
*/
```
