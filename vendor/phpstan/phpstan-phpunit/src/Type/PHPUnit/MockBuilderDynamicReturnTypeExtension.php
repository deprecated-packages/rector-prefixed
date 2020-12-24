<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\PHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockBuilder;
class MockBuilderDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockBuilder::class;
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return !\in_array($methodReflection->getName(), ['getMock', 'getMockForAbstractClass', 'getMockForTrait'], \true);
    }
    public function getTypeFromMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $scope->getType($methodCall->var);
    }
}
