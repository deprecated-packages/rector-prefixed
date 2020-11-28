<?php

namespace _PhpScoperabd03f0baf05\PropertiesNamespace;

use _PhpScoperabd03f0baf05\SomeNamespace\Amet as Dolor;
use _PhpScoperabd03f0baf05\SomeGroupNamespace\One;
use _PhpScoperabd03f0baf05\SomeGroupNamespace\Two as Too;
use _PhpScoperabd03f0baf05\SomeGroupNamespace\Three;
/**
 * @property-read string $overriddenReadOnlyProperty
 * @property-read string $documentElement
 */
abstract class Foo extends \_PhpScoperabd03f0baf05\PropertiesNamespace\Bar
{
    private $mixedProperty;
    /** @var Foo|Bar */
    private $unionTypeProperty;
    /**
     * @var int
     * @var int
     */
    private $anotherMixedProperty;
    /**
     * @vaz int
     */
    private $yetAnotherMixedProperty;
    /** @var int */
    private $integerProperty;
    /** @var integer */
    private $anotherIntegerProperty;
    /** @var array */
    private $arrayPropertyOne;
    /** @var mixed[] */
    private $arrayPropertyOther;
    /**
     * @var Lorem
     */
    private $objectRelative;
    /**
     * @var \SomeOtherNamespace\Ipsum
     */
    private $objectFullyQualified;
    /**
     * @var Dolor
     */
    private $objectUsed;
    /**
     * @var null|int
     */
    private $nullableInteger;
    /**
     * @var Dolor|null
     */
    private $nullableObject;
    /**
     * @var self
     */
    private $selfType;
    /**
     * @var static
     */
    private $staticType;
    /**
     * @var null
     */
    private $nullType;
    /**
     * @var Bar
     */
    private $barObject;
    /**
     * @var [$invalidType]
     */
    private $invalidTypeProperty;
    /**
     * @var resource
     */
    private $resource;
    /**
     * @var array[array]
     */
    private $yetAnotherAnotherMixedParameter;
    /**
     * @var \\Test\Bar
     */
    private $yetAnotherAnotherAnotherMixedParameter;
    /**
     * @var string
     */
    private static $staticStringProperty;
    /**
     * @var One
     */
    private $groupUseProperty;
    /**
     * @var Too
     */
    private $anotherGroupUseProperty;
    /**
     * {@inheritDoc}
     */
    protected $inheritDocProperty;
    /**
     * @inheritDoc
     */
    protected $inheritDocWithoutCurlyBracesProperty;
    protected $implicitInheritDocProperty;
    public function doFoo()
    {
        die;
    }
}
