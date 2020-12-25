<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Routing;

use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\UseNodesToAddCollector;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class ExplicitRouteAnnotationDecorator
{
    /**
     * @var string
     */
    public const HAS_ROUTE_ANNOTATION = 'has_route_annotation';
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    public function __construct(\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function decorateClassMethodWithRouteAnnotation(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode $symfonyRouteTagValueNode) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->addTagValueNodeWithShortName($symfonyRouteTagValueNode);
        $fullyQualifiedObjectType = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::CLASS_NAME);
        $this->useNodesToAddCollector->addUseImport($classMethod, $fullyQualifiedObjectType);
        // remove
        $this->useNodesToAddCollector->removeShortUse($classMethod, 'Route');
        $classMethod->setAttribute(self::HAS_ROUTE_ANNOTATION, \true);
    }
}
