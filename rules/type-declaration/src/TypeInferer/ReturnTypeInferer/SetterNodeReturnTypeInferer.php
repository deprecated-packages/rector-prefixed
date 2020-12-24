<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\FunctionLikeManipulator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer;
final class SetterNodeReturnTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var FunctionLikeManipulator
     */
    private $functionLikeManipulator;
    /**
     * @var AssignToPropertyTypeInferer
     */
    private $assignToPropertyTypeInferer;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer $assignToPropertyTypeInferer, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\FunctionLikeManipulator $functionLikeManipulator)
    {
        $this->functionLikeManipulator = $functionLikeManipulator;
        $this->assignToPropertyTypeInferer = $assignToPropertyTypeInferer;
    }
    public function inferFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classLike = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
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
