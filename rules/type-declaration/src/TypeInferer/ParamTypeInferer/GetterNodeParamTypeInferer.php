<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterNodeParamTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    /**
     * @var PropertyFetchAssignManipulator
     */
    private $propertyFetchAssignManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator $propertyFetchAssignManipulator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
        $this->propertyFetchAssignManipulator = $propertyFetchAssignManipulator;
    }
    public function inferParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        $propertyNames = $this->propertyFetchAssignManipulator->getPropertyNamesOfAssignOfVariable($classMethod, $paramName);
        if ($propertyNames === []) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $returnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        // resolve property assigns
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($propertyNames, &$returnType) : ?int {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ || $node->expr === null) {
                return null;
            }
            $isMatch = $this->propertyFetchManipulator->isLocalPropertyOfNames($node->expr, $propertyNames);
            if (!$isMatch) {
                return null;
            }
            // what is return type?
            /** @var ClassMethod|null $classMethod */
            $classMethod = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
            if (!$classMethod instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
                return null;
            }
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                return null;
            }
            $methodReturnType = $phpDocInfo->getReturnType();
            if ($methodReturnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                return null;
            }
            $returnType = $methodReturnType;
            return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $returnType;
    }
}
