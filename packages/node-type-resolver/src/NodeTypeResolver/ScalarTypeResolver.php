<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\DNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\MagicConst;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
final class ScalarTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return class-string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar::class];
    }
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\DNumber) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType($node->value);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($node->value);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType($node->value);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\MagicConst) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($node->getName());
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException();
    }
}
