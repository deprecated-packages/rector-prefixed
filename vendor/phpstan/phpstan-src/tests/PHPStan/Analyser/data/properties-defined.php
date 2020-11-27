<?php

namespace _PhpScoperbd5d0c5f7638\PropertiesNamespace;

use DOMDocument;
use _PhpScoperbd5d0c5f7638\SomeNamespace\Sit as Dolor;
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
    public function doBar() : \_PhpScoperbd5d0c5f7638\PropertiesNamespace\Self
    {
    }
}
