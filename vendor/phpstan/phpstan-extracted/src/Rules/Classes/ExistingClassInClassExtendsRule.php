<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck;
use RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
class ExistingClassInClassExtendsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Class_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->extends === null) {
            return [];
        }
        $extendedClassName = (string) $node->extends;
        $messages = $this->classCaseSensitivityCheck->checkClassNames([new \RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair($extendedClassName, $node->extends)]);
        $currentClassName = null;
        if (isset($node->namespacedName)) {
            $currentClassName = (string) $node->namespacedName;
        }
        if (!$this->reflectionProvider->hasClass($extendedClassName)) {
            if (!$scope->isInClassExists($extendedClassName)) {
                $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends unknown class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->discoveringSymbolsTip()->build();
            }
        } else {
            $reflection = $this->reflectionProvider->getClass($extendedClassName);
            if ($reflection->isInterface()) {
                $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends interface %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->build();
            } elseif ($reflection->isTrait()) {
                $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends trait %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->build();
            } elseif ($reflection->isFinalByKeyword()) {
                $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends final class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->build();
            }
        }
        return $messages;
    }
}
