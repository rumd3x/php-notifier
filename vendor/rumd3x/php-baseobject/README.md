# php-baseobject
A very helpful class to extend from and use as a base for other classes.

## Installation
To install via composer add this to your composer.json
```json
"minimum-stability": "dev",
"prefer-stable": true
```
And then run
```sh
  composer require "rumd3x/php-baseobject:*"
```

## Usage
### Inheriting stuff

Just make any class extending the BaseObject
```php
use Rumd3x\BaseObject\BaseObject;

class MyClass extends BaseObject {
    // Your class definition
    private $my_property;
}
```

### Automatic getters and setters
To use the automatic getters and setters, make your properties snake case, and your methods camel case.
```php
$obj = new MyClass;
$obj->my_property = 'value'; 
// This will automatically do $obj->setMyProperty('value'); if you have defined this method. 

$prop_value = $obj->my_property; 
// This will automatically do $prop_value = $obj->getMyProperty(); if you have defined this method. 
```

### Helpers
There are several standard helper method on the base object to help on object manipulation in addidition to the already defined php magic methods.
```php
$obj = new MyClass;

// BaseObject::parse($data) Creates a new instance base on the contents of $data.
// Data can be either an object of any class, an array, a json string or a XML string.
MyClass::parse($data); // Returns instance of MyClass.
$obj->parse($data); // Casts $data into the already existing instance.


$obj->toArray(); // Converts the object to an array.
$obj->toJson(); // Converts the object to a json string representation.
$obj->toXml(); // Converts the object to a XML string representation.

// You can also safely use the object to along side with strings.
echo $obj;
$string = "my object value => {$obj}";
```
