<?php

namespace _PhpScoper88fe6e0ad041\PropertiesNamespace;

use DOMDocument;
use _PhpScoper88fe6e0ad041\SomeNamespace\Sit as Dolor;
/**
 * @property-read int $readOnlyProperty
 * @property-read int $overriddenReadOnlyProperty
 */
class Bar extends \DOMDocument
{
    /**
     * @var Dolor
     */
    protected $inheritedProperty;
    /**
     * @var self
     */
    protected $inheritDocProperty;
    /**
     * @var self
     */
    protected $inheritDocWithoutCurlyBracesProperty;
    /**
     * @var self
     */
    protected $implicitInheritDocProperty;
    public function doBar() : \_PhpScoper88fe6e0ad041\PropertiesNamespace\Self
    {
    }
}
