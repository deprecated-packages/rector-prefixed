<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClosureType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
final class ClosureTypeToCallReflectionResolver implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ClosureType;
    }
    /**
     * @param ClosureType $type
     */
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeFunctionReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeFunctionReflection('{closure}', $type->getCallableParametersAcceptors($classMemberAccessAnswerer), null, \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
    }
}
