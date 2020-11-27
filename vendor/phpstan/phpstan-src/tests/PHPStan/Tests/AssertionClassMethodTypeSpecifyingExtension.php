<?php

declare (strict_types=1);
namespace PHPStan\Tests;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\StringType;
class AssertionClassMethodTypeSpecifyingExtension implements \PHPStan\Type\MethodTypeSpecifyingExtension
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
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        if ($this->nullContext === null) {
            return $methodReflection->getName() === 'assertString';
        }
        if ($this->nullContext) {
            return $methodReflection->getName() === 'assertString' && $context->null();
        }
        return $methodReflection->getName() === 'assertString' && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        return new \PHPStan\Analyser\SpecifiedTypes(['$foo' => [$node->args[0]->value, new \PHPStan\Type\StringType()]]);
    }
}
