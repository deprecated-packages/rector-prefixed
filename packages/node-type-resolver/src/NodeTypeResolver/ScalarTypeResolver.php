<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
final class ScalarTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return class-string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar::class];
    }
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType($node->value);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType($node->value);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType($node->value);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType($node->getName());
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException();
    }
}
