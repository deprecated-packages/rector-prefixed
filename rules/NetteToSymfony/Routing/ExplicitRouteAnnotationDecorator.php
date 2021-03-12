<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Routing;

use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
final class ExplicitRouteAnnotationDecorator
{
    /**
     * @var string
     */
    public const HAS_ROUTE_ANNOTATION = 'has_route_annotation';
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function decorateClassMethodWithRouteAnnotation(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode $symfonyRouteTagValueNode) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $phpDocInfo->addTagValueNode($symfonyRouteTagValueNode);
        $classMethod->setAttribute(self::HAS_ROUTE_ANNOTATION, \true);
    }
}
