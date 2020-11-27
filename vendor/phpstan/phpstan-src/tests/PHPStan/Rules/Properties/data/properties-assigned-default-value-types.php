<?php

namespace _PhpScoper88fe6e0ad041\PropertiesAssignedDefaultValuesTypes;

class Foo
{
    /** @var string */
    private $propertyWithoutDefaultValue;
    /** @var string */
    private $stringProperty = 'foo';
    /** @var string */
    private $stringPropertyWithWrongDefaultValue = 1;
    /** @var string */
    private static $staticStringPropertyWithWrongDefaultValue = 1;
    /** @var string */
    private $stringPropertyWithDefaultNullValue = null;
    /** @var array<string,string> */
    private static $windowsNtVersions = ['2000' => '5.0', 'xp' => '5.1'];
}