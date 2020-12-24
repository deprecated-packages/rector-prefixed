<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use function sprintf;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPhpDocVarTagTypeRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var \PHPStan\Rules\Generics\GenericObjectTypeCheck */
    private $genericObjectTypeCheck;
    /** @var MissingTypehintCheck */
    private $missingTypehintCheck;
    /** @var bool */
    private $checkClassCaseSensitivity;
    /** @var bool */
    private $checkMissingVarTagTypehint;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoperb75b35f52b74\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck, \_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck, bool $checkClassCaseSensitivity, bool $checkMissingVarTagTypehint)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
        $this->missingTypehintCheck = $missingTypehintCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
        $this->checkMissingVarTagTypehint = $checkMissingVarTagTypehint;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignRef && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Static_) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $function = $scope->getFunction();
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $function !== null ? $function->getName() : null, $docComment->getText());
        $errors = [];
        foreach ($resolvedPhpDoc->getVarTags() as $name => $varTag) {
            $varTagType = $varTag->getType();
            $identifier = 'PHPDoc tag @var';
            if (\is_string($name)) {
                $identifier .= \sprintf(' for variable $%s', $name);
            }
            if ($varTagType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType || $varTagType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType && !$varTagType->isExplicit()) {
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s contains unresolvable type.', $identifier))->line($docComment->getStartLine())->build();
                continue;
            }
            if ($this->checkMissingVarTagTypehint) {
                foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($varTagType) as $iterableType) {
                    $iterableTypeDescription = $iterableType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
                    $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s has no value type specified in iterable type %s.', $identifier, $iterableTypeDescription))->tip(\sprintf(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
                }
            }
            $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($varTagType, \sprintf('%s contains generic type %%s but class %%s is not generic.', $identifier), \sprintf('Generic type %%s in %s does not specify all template types of class %%s: %%s', $identifier), \sprintf('Generic type %%s in %s specifies %%d template types, but class %%s supports only %%d: %%s', $identifier), \sprintf('Type %%s in generic type %%s in %s is not subtype of template type %%s of class %%s.', $identifier)));
            foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($varTagType) as [$innerName, $genericTypeNames]) {
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s contains generic %s but does not specify its types: %s', $identifier, $innerName, \implode(', ', $genericTypeNames)))->tip(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
            }
            $referencedClasses = $varTagType->getReferencedClasses();
            foreach ($referencedClasses as $referencedClass) {
                if ($this->reflectionProvider->hasClass($referencedClass)) {
                    if ($this->reflectionProvider->getClass($referencedClass)->isTrait()) {
                        $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf(\sprintf('%s has invalid type %%s.', $identifier), $referencedClass))->build();
                    }
                    continue;
                }
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf(\sprintf('%s contains unknown class %%s.', $identifier), $referencedClass))->discoveringSymbolsTip()->build();
            }
            if (!$this->checkClassCaseSensitivity) {
                continue;
            }
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($node) : ClassNameNodePair {
                return new \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair($class, $node);
            }, $referencedClasses)));
        }
        return $errors;
    }
}
