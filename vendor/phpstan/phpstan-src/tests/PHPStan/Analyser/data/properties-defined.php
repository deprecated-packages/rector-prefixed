<?php

namespace _PhpScoperabd03f0baf05\PropertiesNamespace;

use DOMDocument;
use _PhpScoperabd03f0baf05\SomeNamespace\Sit as Dolor;
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
    public function doBar() : \_PhpScoperabd03f0baf05\PropertiesNamespace\Self
    {
    }
}
