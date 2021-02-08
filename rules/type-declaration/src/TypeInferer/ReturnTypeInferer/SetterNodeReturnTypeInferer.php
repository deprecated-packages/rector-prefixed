<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\NodeManipulator\FunctionLikeManipulator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer;
final class SetterNodeReturnTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var FunctionLikeManipulator
     */
    private $functionLikeManipulator;
    /**
     * @var AssignToPropertyTypeInferer
     */
    private $assignToPropertyTypeInferer;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer $assignToPropertyTypeInferer, \Rector\Core\NodeManipulator\FunctionLikeManipulator $functionLikeManipulator)
    {
        $this->functionLikeManipulator = $functionLikeManipulator;
        $this->assignToPropertyTypeInferer = $assignToPropertyTypeInferer;
    }
    public function inferFunctionLike(\PhpParser\Node\FunctionLike $functionLike) : \PHPStan\Type\Type
    {
        $classLike = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return new \PHPStan\Type\MixedType();
        }
        $returnedPropertyNames = $this->functionLikeManipulator->getReturnedLocalPropertyNames($functionLike);
        $types = [];
        foreach ($returnedPropertyNames as $returnedPropertyName) {
            $types[] = $this->assignToPropertyTypeInferer->inferPropertyInClassLike($returnedPropertyName, $classLike);
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    public function getPriority() : int
    {
        return 600;
    }
}
