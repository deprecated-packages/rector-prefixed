<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\DNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\MagicConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
final class ScalarTypeResolver implements \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return class-string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar::class];
    }
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\DNumber) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType($node->value);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($node->value);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType($node->value);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\MagicConst) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($node->getName());
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException();
    }
}
