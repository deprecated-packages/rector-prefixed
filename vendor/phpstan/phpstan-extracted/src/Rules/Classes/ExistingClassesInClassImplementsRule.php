<?php

declare (strict_types=1);
namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassNameNodePair;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
class ExistingClassesInClassImplementsRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Class_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\PhpParser\Node\Name $interfaceName) : ClassNameNodePair {
            return new \PHPStan\Rules\ClassNameNodePair((string) $interfaceName, $interfaceName);
        }, $node->implements));
        $currentClassName = null;
        if (isset($node->namespacedName)) {
            $currentClassName = (string) $node->namespacedName;
        }
        foreach ($node->implements as $implements) {
            $implementedClassName = (string) $implements;
            if (!$this->reflectionProvider->hasClass($implementedClassName)) {
                if (!$scope->isInClassExists($implementedClassName)) {
                    $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements unknown interface %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->discoveringSymbolsTip()->build();
                }
            } else {
                $reflection = $this->reflectionProvider->getClass($implementedClassName);
                if ($reflection->isClass()) {
                    $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->build();
                } elseif ($reflection->isTrait()) {
                    $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements trait %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->build();
                }
            }
        }
        return $messages;
    }
}
