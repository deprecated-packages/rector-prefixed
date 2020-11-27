<?php

namespace _PhpScoper006a73f0e455\PropertiesNamespace;

use DOMDocument;
use _PhpScoper006a73f0e455\SomeNamespace\Sit as Dolor;
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
    public function doBar() : \_PhpScoper006a73f0e455\PropertiesNamespace\Self
    {
    }
}
