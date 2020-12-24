<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Classes;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
class ExistingClassesInClassImplementsRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\_PhpScopere8e811afab72\PhpParser\Node\Name $interfaceName) : ClassNameNodePair {
            return new \_PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair((string) $interfaceName, $interfaceName);
        }, $node->implements));
        $currentClassName = null;
        if (isset($node->namespacedName)) {
            $currentClassName = (string) $node->namespacedName;
        }
        foreach ($node->implements as $implements) {
            $implementedClassName = (string) $implements;
            if (!$this->reflectionProvider->hasClass($implementedClassName)) {
                if (!$scope->isInClassExists($implementedClassName)) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements unknown interface %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->discoveringSymbolsTip()->build();
                }
            } else {
                $reflection = $this->reflectionProvider->getClass($implementedClassName);
                if ($reflection->isClass()) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->build();
                } elseif ($reflection->isTrait()) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s implements trait %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $implementedClassName))->nonIgnorable()->build();
                }
            }
        }
        return $messages;
    }
}
