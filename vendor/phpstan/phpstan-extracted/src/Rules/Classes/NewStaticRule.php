<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class NewStaticRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
            return [];
        }
        if (!$scope->isInClass()) {
            return [];
        }
        if (\strtolower($node->class->toString()) !== 'static') {
            return [];
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection->isFinal()) {
            return [];
        }
        $messages = [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message('Unsafe usage of new static().')->tip('Consider making the class or the constructor final.')->build()];
        if (!$classReflection->hasConstructor()) {
            return $messages;
        }
        $constructor = $classReflection->getConstructor();
        if ($constructor->getPrototype()->getDeclaringClass()->isInterface()) {
            return [];
        }
        if ($constructor instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpMethodReflection) {
            if ($constructor->isFinal()->yes()) {
                return [];
            }
            $prototype = $constructor->getPrototype();
            if ($prototype->isAbstract()) {
                return [];
            }
        }
        return $messages;
    }
}
