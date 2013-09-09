<?php
/*
|--------------------------------------------------------------------------
| Extension Bootstrap
|--------------------------------------------------------------------------
|
| To use extension, please register each class with their individual factories
| examples are show below:
|
| Override Built-in Platform
|
|
*/

use Faker\PlatformFactory;
use Faker\Components\Engine\Common\Formatter\FormatterFactory;
use Faker\Components\Engine\Common\TypeRepository;
use Faker\Locale\LocaleFactory;
use Doctrine\DBAL\Types\Type;

/*
|--------------------------------------------------------------------------
| Doctrine Platforms
|--------------------------------------------------------------------------
|
| To include new platforms must tell Faker\\PlatformFactory what the new or overriden
| extensions are.
|
|
| Override Built-in Platform (mysql):
|
|   PlatformFactory::registerExtension('mysql','Faker\\Components\\Extension\\Doctrine\\Platforms\\MySqlPlatform');
|
| Include New MyPlatform:
|
| PlatformFactory::registerExtension('myplatform','Faker\\Components\\Extension\\Doctrine\\Platforms\\MyPlatform');
|
*/

    PlatformFactory::registerExtension('mysql','Faker\\Extension\\Doctrine\\Platforms\\MySqlPlatform');

 
/*
|--------------------------------------------------------------------------
| Doctrine Column Types
|--------------------------------------------------------------------------
|
| To include new column types use the Doctine Type Static Factory
| You don't need to add these types to a platform, Faker pull them directly.
|
|  Add new Column types (mysql):
|
|  //Type::addType('point', 'Geo\Types\Point'); 
|
*/ 

   //Type::addType('point', 'Geo\Types\Point');
    
    
/*
|--------------------------------------------------------------------------
| Faker DataTypes
|--------------------------------------------------------------------------
| 
| To Add a new datatype a it must be registered, and the object
| are extending from base Type.
|
| You may also override built in types using the same key.
|
| Example:
|
| TypeFactory::registerExtension('vector','Faker\\Extension\\Faker\\Type\\Vector');
*/

 //TypeRepository::registerExtension('vector','Faker\\Extension\\Faker\\Type\\Vector');
 TypeRepository::registerExtension('rental.return','Faker\\Extension\\Faker\\Type\\RentalReturn');
 TypeRepository::registerExtension('password','Faker\\Extension\\Faker\\Type\\Password');

/*
|--------------------------------------------------------------------------
| Faker Formatters
|--------------------------------------------------------------------------
|
| Register a new formatter, which control how data is written to the writter.
|
| FormatterFactory::registerExtension('mongo','Faker\\Components\\Extension\\Faker\\Formatter\\Mongo');
|
*/ 
    
  //FormatterFactory::registerExtension('mongo','Faker\\Components\\Extension\\Faker\\Formatter\\Mongo');


/*
|--------------------------------------------------------------------------
| Faker Locales
|--------------------------------------------------------------------------
|
| Register a new Locale, which provide locale specific text to the generators.
|
| LocaleFactory::registerExtension('french','Faker\\Components\\Extension\\Locale\\FrenchLocale');
|
*/ 

  //LocaleFactory::registerExtension('french','Faker\\Components\\Extension\\Locale\\FrenchLocale');

/* End of File */
