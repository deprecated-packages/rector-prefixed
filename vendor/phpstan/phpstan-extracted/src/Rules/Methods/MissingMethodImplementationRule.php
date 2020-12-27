<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
/**
 * @implements Rule<InClassNode>
 */
class MissingMethodImplementationRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $classReflection = $node->getClassReflection();
        if ($classReflection->isInterface()) {
            return [];
        }
        if ($classReflection->isAbstract()) {
            return [];
        }
        $messages = [];
        try {
            $nativeMethods = $classReflection->getNativeMethods();
        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            return [];
        }
        foreach ($nativeMethods as $method) {
            if (!\method_exists($method, 'isAbstract')) {
                continue;
            }
            if (!$method->isAbstract()) {
                continue;
            }
            $declaringClass = $method->getDeclaringClass();
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Non-abstract class %s contains abstract method %s() from %s %s.', $classReflection->getDisplayName(), $method->getName(), $declaringClass->isInterface() ? 'interface' : 'class', $declaringClass->getDisplayName()))->nonIgnorable()->build();
        }
        return $messages;
    }
}
