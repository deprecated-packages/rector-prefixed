<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\DeadCode;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\ClassPropertiesNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\Property\PropertyRead;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
/**
 * @implements Rule<ClassPropertiesNode>
 */
class UnusedPrivatePropertyRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var ReadWritePropertiesExtensionProvider */
    private $extensionProvider;
    /** @var string[] */
    private $alwaysWrittenTags;
    /** @var string[] */
    private $alwaysReadTags;
    /** @var bool */
    private $checkUninitializedProperties;
    /**
     * @param ReadWritePropertiesExtensionProvider $extensionProvider
     * @param string[] $alwaysWrittenTags
     * @param string[] $alwaysReadTags
     */
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider $extensionProvider, array $alwaysWrittenTags, array $alwaysReadTags, bool $checkUninitializedProperties)
    {
        $this->extensionProvider = $extensionProvider;
        $this->alwaysWrittenTags = $alwaysWrittenTags;
        $this->alwaysReadTags = $alwaysReadTags;
        $this->checkUninitializedProperties = $checkUninitializedProperties;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\ClassPropertiesNode::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $classType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classReflection->getName());
        $properties = [];
        foreach ($node->getProperties() as $property) {
            if (!$property->isPrivate()) {
                continue;
            }
            $alwaysRead = \false;
            $alwaysWritten = \false;
            if ($property->getPhpDoc() !== null) {
                $text = $property->getPhpDoc();
                foreach ($this->alwaysReadTags as $tag) {
                    if (\strpos($text, $tag) === \false) {
                        continue;
                    }
                    $alwaysRead = \true;
                    break;
                }
                foreach ($this->alwaysWrittenTags as $tag) {
                    if (\strpos($text, $tag) === \false) {
                        continue;
                    }
                    $alwaysWritten = \true;
                    break;
                }
            }
            $propertyName = $property->getName();
            if (!$alwaysRead || !$alwaysWritten) {
                if (!$classReflection->hasNativeProperty($propertyName)) {
                    continue;
                }
                $propertyReflection = $classReflection->getNativeProperty($propertyName);
                foreach ($this->extensionProvider->getExtensions() as $extension) {
                    if ($alwaysRead && $alwaysWritten) {
                        break;
                    }
                    if (!$alwaysRead && $extension->isAlwaysRead($propertyReflection, $propertyName)) {
                        $alwaysRead = \true;
                    }
                    if ($alwaysWritten || !$extension->isAlwaysWritten($propertyReflection, $propertyName)) {
                        continue;
                    }
                    $alwaysWritten = \true;
                }
            }
            $read = $alwaysRead;
            $written = $alwaysWritten || $property->getDefault() !== null;
            $properties[$propertyName] = ['read' => $read, 'written' => $written, 'node' => $property];
        }
        foreach ($node->getPropertyUsages() as $usage) {
            $fetch = $usage->getFetch();
            if ($fetch->name instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier) {
                $propertyNames = [$fetch->name->toString()];
            } else {
                $propertyNameType = $usage->getScope()->getType($fetch->name);
                $strings = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantStrings($propertyNameType);
                if (\count($strings) === 0) {
                    return [];
                }
                $propertyNames = \array_map(static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType $type) : string {
                    return $type->getValue();
                }, $strings);
            }
            if ($fetch instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
                $fetchedOnType = $usage->getScope()->getType($fetch->var);
            } else {
                if (!$fetch->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                    continue;
                }
                $fetchedOnType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($usage->getScope()->resolveName($fetch->class));
            }
            if ($classType->isSuperTypeOf($fetchedOnType)->no()) {
                continue;
            }
            if ($fetchedOnType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                continue;
            }
            foreach ($propertyNames as $propertyName) {
                if (!\array_key_exists($propertyName, $properties)) {
                    continue;
                }
                if ($usage instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\Property\PropertyRead) {
                    $properties[$propertyName]['read'] = \true;
                } else {
                    $properties[$propertyName]['written'] = \true;
                }
            }
        }
        $constructors = [];
        $classReflection = $scope->getClassReflection();
        if ($classReflection->hasConstructor()) {
            $constructors[] = $classReflection->getConstructor()->getName();
        }
        [$uninitializedProperties] = $node->getUninitializedProperties($scope, $constructors, $this->extensionProvider->getExtensions());
        $errors = [];
        foreach ($properties as $name => $data) {
            $propertyNode = $data['node'];
            if ($propertyNode->isStatic()) {
                $propertyName = \sprintf('Static property %s::$%s', $scope->getClassReflection()->getDisplayName(), $name);
            } else {
                $propertyName = \sprintf('Property %s::$%s', $scope->getClassReflection()->getDisplayName(), $name);
            }
            if (!$data['read']) {
                if (!$data['written']) {
                    $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is unused.', $propertyName))->line($propertyNode->getStartLine())->identifier('deadCode.unusedProperty')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'propertyName' => $name])->build();
                } else {
                    $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is never read, only written.', $propertyName))->line($propertyNode->getStartLine())->build();
                }
            } elseif (!$data['written'] && (!\array_key_exists($name, $uninitializedProperties) || !$this->checkUninitializedProperties)) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is never written, only read.', $propertyName))->line($propertyNode->getStartLine())->build();
            }
        }
        return $errors;
    }
}
