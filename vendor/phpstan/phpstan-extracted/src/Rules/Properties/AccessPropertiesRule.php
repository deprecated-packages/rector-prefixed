<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Properties;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\PropertyFetch>
 */
class AccessPropertiesRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMagicProperties;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMagicProperties)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMagicProperties = $reportMagicProperties;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            $names = [$node->name->name];
        } else {
            $names = \array_map(static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType $type) : string {
                return $type->getValue();
            }, \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($node->name)));
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
    private function processSingleProperty(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $node, string $name) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, \sprintf('Access to property $%s on an unknown class %%s.', $name), static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) use($name) : bool {
            return $type->canAccessProperties()->yes() && $type->hasProperty($name)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if (!$type->canAccessProperties()->yes()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access property $%s on %s.', $name, $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
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
                        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to private property $%s of parent class %s.', $name, $parentClassReflection->getDisplayName()))->build()];
                    }
                    $parentClassReflection = $parentClassReflection->getParentClass();
                }
            }
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an undefined property %s::$%s.', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        $propertyReflection = $type->getProperty($name, $scope);
        if (!$scope->canAccessProperty($propertyReflection)) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s property %s::$%s.', $propertyReflection->isPrivate() ? 'private' : 'protected', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        return [];
    }
}
