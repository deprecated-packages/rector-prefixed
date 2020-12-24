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
class ExistingClassInClassExtendsRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        if ($node->extends === null) {
            return [];
        }
        $extendedClassName = (string) $node->extends;
        $messages = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair($extendedClassName, $node->extends)]);
        $currentClassName = null;
        if (isset($node->namespacedName)) {
            $currentClassName = (string) $node->namespacedName;
        }
        if (!$this->reflectionProvider->hasClass($extendedClassName)) {
            if (!$scope->isInClassExists($extendedClassName)) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends unknown class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->discoveringSymbolsTip()->build();
            }
        } else {
            $reflection = $this->reflectionProvider->getClass($extendedClassName);
            if ($reflection->isInterface()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends interface %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->build();
            } elseif ($reflection->isTrait()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends trait %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->build();
            } elseif ($reflection->isFinalByKeyword()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s extends final class %s.', $currentClassName !== null ? \sprintf('Class %s', $currentClassName) : 'Anonymous class', $extendedClassName))->nonIgnorable()->build();
            }
        }
        return $messages;
    }
}
