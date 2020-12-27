<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\ClassPropertyNode;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck;
use RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
class ExistingClassesInPropertiesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkClassCaseSensitivity;
    /** @var bool */
    private $checkThisOnly;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkClassCaseSensitivity, bool $checkThisOnly)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
        $this->checkThisOnly = $checkThisOnly;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($node->getName());
        if ($this->checkThisOnly) {
            $referencedClasses = $propertyReflection->getNativeType()->getReferencedClasses();
        } else {
            $referencedClasses = \array_merge($propertyReflection->getNativeType()->getReferencedClasses(), $propertyReflection->getPhpDocType()->getReferencedClasses());
        }
        $errors = [];
        foreach ($referencedClasses as $referencedClass) {
            if ($this->reflectionProvider->hasClass($referencedClass)) {
                if ($this->reflectionProvider->getClass($referencedClass)->isTrait()) {
                    $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s has invalid type %s.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $referencedClass))->build();
                }
                continue;
            }
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s has unknown class %s as its type.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $referencedClass))->discoveringSymbolsTip()->build();
        }
        if ($this->checkClassCaseSensitivity) {
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($node) : ClassNameNodePair {
                return new \RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair($class, $node);
            }, $referencedClasses)));
        }
        return $errors;
    }
}
