<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Methods;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Node\InClassNode;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
/**
 * @implements Rule<InClassNode>
 */
class MissingMethodImplementationRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
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
        } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
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
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Non-abstract class %s contains abstract method %s() from %s %s.', $classReflection->getDisplayName(), $method->getName(), $declaringClass->isInterface() ? 'interface' : 'class', $declaringClass->getDisplayName()))->nonIgnorable()->build();
        }
        return $messages;
    }
}
