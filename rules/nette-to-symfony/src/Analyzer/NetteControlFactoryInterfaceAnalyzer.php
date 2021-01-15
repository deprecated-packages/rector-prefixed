<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Analyzer;

use PhpParser\Node\Stmt\Interface_;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class NetteControlFactoryInterfaceAnalyzer
{
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @see https://doc.nette.org/en/3.0/components#toc-components-with-dependencies
     */
    public function isComponentFactoryInterface(\PhpParser\Node\Stmt\Interface_ $interface) : bool
    {
        foreach ($interface->getMethods() as $classMethod) {
            $returnType = $this->returnTypeInferer->inferFunctionLike($classMethod);
            if (!$returnType instanceof \PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $className = $this->nodeTypeResolver->getFullyQualifiedClassName($returnType);
            if (\is_a($className, 'Nette\\Application\\UI\\Control', \true)) {
                return \true;
            }
            if (\is_a($className, 'Nette\\Application\\UI\\Form', \true)) {
                return \true;
            }
        }
        return \false;
    }
}
