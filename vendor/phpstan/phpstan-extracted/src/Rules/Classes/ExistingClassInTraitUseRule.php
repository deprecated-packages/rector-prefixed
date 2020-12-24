<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TraitUse>
 */
class ExistingClassInTraitUseRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\TraitUse::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $traitName) : ClassNameNodePair {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair((string) $traitName, $traitName);
        }, $node->traits));
        if (!$scope->isInClass()) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection->isInterface()) {
            if (!$scope->isInTrait()) {
                foreach ($node->traits as $trait) {
                    $messages[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s uses trait %s.', $classReflection->getName(), (string) $trait))->nonIgnorable()->build();
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
                    $messages[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses unknown trait %s.', $currentName, $traitName))->nonIgnorable()->discoveringSymbolsTip()->build();
                } else {
                    $reflection = $this->reflectionProvider->getClass($traitName);
                    if ($reflection->isClass()) {
                        $messages[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses class %s.', $currentName, $traitName))->nonIgnorable()->build();
                    } elseif ($reflection->isInterface()) {
                        $messages[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s uses interface %s.', $currentName, $traitName))->nonIgnorable()->build();
                    }
                }
            }
        }
        return $messages;
    }
}
