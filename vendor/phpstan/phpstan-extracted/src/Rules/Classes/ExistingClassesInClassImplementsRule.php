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
class ExistingClassesInClassImplementsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
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
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\PhpParser\Node\Name $interfaceName) : ClassNameNodePair {
            return new \RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair((string) $interfaceName, $interfaceName);
        }, $node->implements));
        $currentClassName = null;
        if (isset($node->namespacedName)) {
            $currentClassName = (string) $node->namespacedName;
        }
        foreach ($node->implements as $implements) {
            $implementedClassName = (string) $implements;
            if (!$this->reflectionProvider->hasClass($implementedClassName)) {
                if (!$scope->isInClassExists($implementedClassName)) {
                    $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements unknown interface %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->discoveringSymbolsTip()->build();
                }
            } else {
                $reflection = $this->reflectionProvider->getClass($implementedClassName);
                if ($reflection->isClass()) {
                    $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->build();
                } elseif ($reflection->isTrait()) {
                    $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements trait %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->build();
                }
            }
        }
        return $messages;
    }
}
