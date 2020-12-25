<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\PropertyFetch>
 */
class AccessPropertiesRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMagicProperties;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMagicProperties)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMagicProperties = $reportMagicProperties;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\PropertyFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \PhpParser\Node\Identifier) {
            $names = [$node->name->name];
        } else {
            $names = \array_map(static function (\PHPStan\Type\Constant\ConstantStringType $type) : string {
                return $type->getValue();
            }, \PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($node->name)));
        }
        $errors = [];
        foreach ($names as $name) {
            $errors = \array_merge($errors, $this->processSingleProperty($scope, $node, $name));
        }
        return $errors;
    }
    /**
     * @param Scope $scope
     * @param PropertyFetch $node
     * @param string $name
     * @return RuleError[]
     */
    private function processSingleProperty(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr\PropertyFetch $node, string $name) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, \sprintf('Access to property $%s on an unknown class %%s.', $name), static function (\PHPStan\Type\Type $type) use($name) : bool {
            return $type->canAccessProperties()->yes() && $type->hasProperty($name)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if (!$type->canAccessProperties()->yes()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access property $%s on %s.', $name, $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        if (!$type->hasProperty($name)->yes()) {
            if ($scope->isSpecified($node)) {
                return [];
            }
            $classNames = $typeResult->getReferencedClasses();
            if (!$this->reportMagicProperties) {
                foreach ($classNames as $className) {
                    if (!$this->reflectionProvider->hasClass($className)) {
                        continue;
                    }
                    $classReflection = $this->reflectionProvider->getClass($className);
                    if ($classReflection->hasNativeMethod('__get') || $classReflection->hasNativeMethod('__set')) {
                        return [];
                    }
                }
            }
            if (\count($classNames) === 1) {
                $referencedClass = $typeResult->getReferencedClasses()[0];
                $propertyClassReflection = $this->reflectionProvider->getClass($referencedClass);
                $parentClassReflection = $propertyClassReflection->getParentClass();
                while ($parentClassReflection !== \false) {
                    if ($parentClassReflection->hasProperty($name)) {
                        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to private property $%s of parent class %s.', $name, $parentClassReflection->getDisplayName()))->build()];
                    }
                    $parentClassReflection = $parentClassReflection->getParentClass();
                }
            }
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an undefined property %s::$%s.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        $propertyReflection = $type->getProperty($name, $scope);
        if (!$scope->canAccessProperty($propertyReflection)) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s property %s::$%s.', $propertyReflection->isPrivate() ? 'private' : 'protected', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        return [];
    }
}
