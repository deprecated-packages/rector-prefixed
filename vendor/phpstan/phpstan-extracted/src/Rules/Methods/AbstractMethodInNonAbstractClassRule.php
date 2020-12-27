<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Stmt\ClassMethod>
 */
class AbstractMethodInNonAbstractClassRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\ClassMethod::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $class = $scope->getClassReflection();
        if ($class->isAbstract()) {
            return [];
        }
        if (!$node->isAbstract()) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Non-abstract class %s contains abstract method %s().', $class->getDisplayName(), $node->name->toString()))->nonIgnorable()->build()];
    }
}
