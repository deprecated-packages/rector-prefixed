<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ClassPropertiesNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassPropertiesNode>
 */
class UninitializedPropertyRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider $extensionProvider, array $additionalConstructors)
    {
        $this->extensionProvider = $extensionProvider;
        $this->additionalConstructors = $additionalConstructors;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\ClassPropertiesNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        [$properties, $prematureAccess] = $node->getUninitializedProperties($scope, $this->getConstructors($classReflection), $this->extensionProvider->getExtensions());
        $errors = [];
        foreach ($properties as $propertyName => $propertyNode) {
            $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s has an uninitialized property $%s. Give it default value or assign it in the constructor.', $classReflection->getDisplayName(), $propertyName))->line($propertyNode->getLine())->build();
        }
        foreach ($prematureAccess as [$propertyName, $line]) {
            $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an uninitialized property %s::$%s.', $classReflection->getDisplayName(), $propertyName))->line($line)->build();
        }
        return $errors;
    }
    /**
     * @param ClassReflection $classReflection
     * @return string[]
     */
    private function getConstructors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection) : array
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
