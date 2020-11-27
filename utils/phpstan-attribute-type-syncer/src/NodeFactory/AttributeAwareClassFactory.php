<?php

declare (strict_types=1);
namespace Rector\Utils\PHPStanAttributeTypeSyncer\NodeFactory;

use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Namespace_;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\Core\PhpParser\Builder\ClassBuilder;
use Rector\Core\PhpParser\Builder\NamespaceBuilder;
use Rector\Core\PhpParser\Builder\TraitUseBuilder;
use Rector\Utils\PHPStanAttributeTypeSyncer\ClassNaming\AttributeClassNaming;
use Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths;
final class AttributeAwareClassFactory
{
    /**
     * @var AttributeClassNaming
     */
    private $attributeClassNaming;
    public function __construct(\Rector\Utils\PHPStanAttributeTypeSyncer\ClassNaming\AttributeClassNaming $attributeClassNaming)
    {
        $this->attributeClassNaming = $attributeClassNaming;
    }
    public function createFromPhpDocParserNodeClass(string $nodeClass) : \PhpParser\Node\Stmt\Namespace_
    {
        if (\_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($nodeClass, '\\Type\\')) {
            $namespace = \Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths::NAMESPACE_TYPE_NODE;
        } else {
            $namespace = \Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths::NAMESPACE_PHPDOC_NODE;
        }
        $namespaceBuilder = new \Rector\Core\PhpParser\Builder\NamespaceBuilder($namespace);
        $shortClassName = $this->attributeClassNaming->createAttributeAwareShortClassName($nodeClass);
        $classBuilder = $this->createClassBuilder($nodeClass, $shortClassName);
        $traitUseBuilder = new \Rector\Core\PhpParser\Builder\TraitUseBuilder(new \PhpParser\Node\Name\FullyQualified(\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait::class));
        $classBuilder->addStmt($traitUseBuilder);
        $namespaceBuilder->addStmt($classBuilder->getNode());
        return $namespaceBuilder->getNode();
    }
    private function createClassBuilder(string $nodeClass, string $shortClassName) : \Rector\Core\PhpParser\Builder\ClassBuilder
    {
        $classBuilder = new \Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        $classBuilder->extend(new \PhpParser\Node\Name\FullyQualified($nodeClass));
        $classBuilder->implement(new \PhpParser\Node\Name\FullyQualified(\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface::class));
        return $classBuilder;
    }
}
