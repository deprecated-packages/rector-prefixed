<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\ClassPropertiesNode;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassPropertiesNode>
 */
class UninitializedPropertyRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var ReadWritePropertiesExtensionProvider */
    private $extensionProvider;
    /** @var string[] */
    private $additionalConstructors;
    /** @var array<string, string[]> */
    private $additionalConstructorsCache = [];
    /**
     * @param string[] $additionalConstructors
     */
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider $extensionProvider, array $additionalConstructors)
    {
        $this->extensionProvider = $extensionProvider;
        $this->additionalConstructors = $additionalConstructors;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\ClassPropertiesNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        [$properties, $prematureAccess] = $node->getUninitializedProperties($scope, $this->getConstructors($classReflection), $this->extensionProvider->getExtensions());
        $errors = [];
        foreach ($properties as $propertyName => $propertyNode) {
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s has an uninitialized property $%s. Give it default value or assign it in the constructor.', $classReflection->getDisplayName(), $propertyName))->line($propertyNode->getLine())->build();
        }
        foreach ($prematureAccess as [$propertyName, $line]) {
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an uninitialized property %s::$%s.', $classReflection->getDisplayName(), $propertyName))->line($line)->build();
        }
        return $errors;
    }
    /**
     * @param ClassReflection $classReflection
     * @return string[]
     */
    private function getConstructors(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection) : array
    {
        if (\array_key_exists($classReflection->getName(), $this->additionalConstructorsCache)) {
            return $this->additionalConstructorsCache[$classReflection->getName()];
        }
        $constructors = [];
        if ($classReflection->hasConstructor()) {
            $constructors[] = $classReflection->getConstructor()->getName();
        }
        foreach ($this->additionalConstructors as $additionalConstructor) {
            [$className, $methodName] = \explode('::', $additionalConstructor);
            foreach ($classReflection->getNativeMethods() as $nativeMethod) {
                if ($nativeMethod->getName() !== $methodName) {
                    continue;
                }
                if ($nativeMethod->getDeclaringClass()->getName() !== $classReflection->getName()) {
                    continue;
                }
                $prototype = $nativeMethod->getPrototype();
                if ($prototype->getDeclaringClass()->getName() !== $className) {
                    continue;
                }
                $constructors[] = $methodName;
            }
        }
        $this->additionalConstructorsCache[$classReflection->getName()] = $constructors;
        return $constructors;
    }
}
