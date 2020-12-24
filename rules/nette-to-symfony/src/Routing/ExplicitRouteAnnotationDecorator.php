<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Routing;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function decorateClassMethodWithRouteAnnotation(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode $symfonyRouteTagValueNode) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->addTagValueNodeWithShortName($symfonyRouteTagValueNode);
        $fullyQualifiedObjectType = new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::CLASS_NAME);
        $this->useNodesToAddCollector->addUseImport($classMethod, $fullyQualifiedObjectType);
        // remove
        $this->useNodesToAddCollector->removeShortUse($classMethod, 'Route');
        $classMethod->setAttribute(self::HAS_ROUTE_ANNOTATION, \true);
    }
}
