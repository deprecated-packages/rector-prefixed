<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Classes;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class NewStaticRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
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
        $messages = [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Unsafe usage of new static().')->tip('Consider making the class or the constructor final.')->build()];
        if (!$classReflection->hasConstructor()) {
            return $messages;
        }
        $constructor = $classReflection->getConstructor();
        if ($constructor->getPrototype()->getDeclaringClass()->isInterface()) {
            return [];
        }
        if ($constructor instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection) {
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
