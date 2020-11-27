<?php

declare (strict_types=1);
namespace PHPStan\Tests;

use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StaticMethodTypeSpecifyingExtension;
class AssertionClassStaticMethodTypeSpecifyingExtension implements \PHPStan\Type\StaticMethodTypeSpecifyingExtension
{
    /** @var bool|null */
    private $nullContext;
    public function __construct(?bool $nullContext)
    {
        $this->nullContext = $nullContext;
    }
    public function getClass() : string
    {
        return \PHPStan\Tests\AssertionClass::class;
    }
    public function isStaticMethodSupported(\PHPStan\Reflection\MethodReflection $staticMethodReflection, \PhpParser\Node\Expr\StaticCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        if ($this->nullContext === null) {
            return $staticMethodReflection->getName() === 'assertInt';
        }
        if ($this->nullContext) {
            return $staticMethodReflection->getName() === 'assertInt' && $context->null();
        }
        return $staticMethodReflection->getName() === 'assertInt' && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\MethodReflection $staticMethodReflection, \PhpParser\Node\Expr\StaticCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        return new \PHPStan\Analyser\SpecifiedTypes(['$bar' => [$node->args[0]->value, new \PHPStan\Type\IntegerType()]]);
    }
}
