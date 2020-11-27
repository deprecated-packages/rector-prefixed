<?php

declare (strict_types=1);
namespace Rector\Utils\PHPStanAttributeTypeSyncer\ClassNaming;

use _PhpScopera143bcca66cb\Nette\Utils\Strings;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths;
final class AttributeClassNaming
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    public function createAttributeAwareShortClassName(string $nodeClass) : string
    {
        $shortMissingNodeClass = $this->classNaming->getShortName($nodeClass);
        return 'AttributeAware' . $shortMissingNodeClass;
    }
    public function createAttributeAwareFactoryShortClassName(string $nodeClass) : string
    {
        $shortMissingNodeClass = $this->classNaming->getShortName($nodeClass);
        return 'AttributeAware' . $shortMissingNodeClass . 'Factory';
    }
    public function createAttributeAwareClassName(string $nodeClass) : string
    {
        if (\_PhpScopera143bcca66cb\Nette\Utils\Strings::contains($nodeClass, '\\Type\\')) {
            $namespace = \Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths::NAMESPACE_TYPE_NODE;
        } else {
            $namespace = \Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths::NAMESPACE_PHPDOC_NODE;
        }
        return $namespace . '\\' . $this->createAttributeAwareShortClassName($nodeClass);
    }
}
