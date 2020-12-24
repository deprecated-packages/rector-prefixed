<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterNodeParamTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    /**
     * @var PropertyFetchAssignManipulator
     */
    private $propertyFetchAssignManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchAssignManipulator $propertyFetchAssignManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
        $this->propertyFetchAssignManipulator = $propertyFetchAssignManipulator;
    }
    public function inferParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        /** @var ClassMethod $classMethod */
        $classMethod = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        $propertyNames = $this->propertyFetchAssignManipulator->getPropertyNamesOfAssignOfVariable($classMethod, $paramName);
        if ($propertyNames === []) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $returnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        // resolve property assigns
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyNames, &$returnType) : ?int {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ || $node->expr === null) {
                return null;
            }
            $isMatch = $this->propertyFetchManipulator->isLocalPropertyOfNames($node->expr, $propertyNames);
            if (!$isMatch) {
                return null;
            }
            // what is return type?
            /** @var ClassMethod|null $classMethod */
            $classMethod = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
            if (!$classMethod instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
                return null;
            }
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                return null;
            }
            $methodReturnType = $phpDocInfo->getReturnType();
            if ($methodReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                return null;
            }
            $returnType = $methodReturnType;
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $returnType;
    }
}
