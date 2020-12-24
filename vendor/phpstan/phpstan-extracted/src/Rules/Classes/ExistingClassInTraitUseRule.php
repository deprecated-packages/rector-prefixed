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
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TraitUse>
 */
class ExistingClassInTraitUseRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\TraitUse::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\_PhpScopere8e811afab72\PhpParser\Node\Name $traitName) : ClassNameNodePair {
            return new \_PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair((string) $traitName, $traitName);
        }, $node->traits));
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection->isInterface()) {
            if (!$scope->isInTrait()) {
                foreach ($node->traits as $trait) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s uses trait %s.', $classReflection->getName(), (string) $trait))->nonIgnorable()->build();
                }
            }
        } else {
            if ($scope->isInTrait()) {
                $currentName = \sprintf('Trait %s', $scope->getTraitReflection()->getName());
            } else {
                if ($classReflection->isAnonymous()) {
                    $currentName = 'Anonymous class';
                } else {
                    $currentName = \sprintf('Class %s', $classReflection->getName());
                }
            }
            foreach ($node->traits as $trait) {
                $traitName = (string) $trait;
                if (!$this->reflectionProvider->hasClass($traitName)) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses unknown trait %s.', $currentName, $traitName))->nonIgnorable()->discoveringSymbolsTip()->build();
                } else {
                    $reflection = $this->reflectionProvider->getClass($traitName);
                    if ($reflection->isClass()) {
                        $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses class %s.', $currentName, $traitName))->nonIgnorable()->build();
                    } elseif ($reflection->isInterface()) {
                        $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses interface %s.', $currentName, $traitName))->nonIgnorable()->build();
                    }
                }
            }
        }
        return $messages;
    }
}
