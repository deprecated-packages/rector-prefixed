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
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TraitUse>
 */
class ExistingClassInTraitUseRule implements \PHPStan\Rules\Rule
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
        return \PhpParser\Node\Stmt\TraitUse::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\PhpParser\Node\Name $traitName) : ClassNameNodePair {
            return new \PHPStan\Rules\ClassNameNodePair((string) $traitName, $traitName);
        }, $node->traits));
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection->isInterface()) {
            if (!$scope->isInTrait()) {
                foreach ($node->traits as $trait) {
                    $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s uses trait %s.', $classReflection->getName(), (string) $trait))->nonIgnorable()->build();
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
                    $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses unknown trait %s.', $currentName, $traitName))->nonIgnorable()->discoveringSymbolsTip()->build();
                } else {
                    $reflection = $this->reflectionProvider->getClass($traitName);
                    if ($reflection->isClass()) {
                        $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses class %s.', $currentName, $traitName))->nonIgnorable()->build();
                    } elseif ($reflection->isInterface()) {
                        $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses interface %s.', $currentName, $traitName))->nonIgnorable()->build();
                    }
                }
            }
        }
        return $messages;
    }
}
