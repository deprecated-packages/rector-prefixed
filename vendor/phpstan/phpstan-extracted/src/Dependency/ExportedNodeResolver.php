<?php

declare (strict_types=1);
namespace PHPStan\Dependency;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Property;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Dependency\ExportedNode\ExportedClassConstantNode;
use PHPStan\Dependency\ExportedNode\ExportedClassNode;
use PHPStan\Dependency\ExportedNode\ExportedFunctionNode;
use PHPStan\Dependency\ExportedNode\ExportedInterfaceNode;
use PHPStan\Dependency\ExportedNode\ExportedMethodNode;
use PHPStan\Dependency\ExportedNode\ExportedParameterNode;
use PHPStan\Dependency\ExportedNode\ExportedPhpDocNode;
use PHPStan\Dependency\ExportedNode\ExportedPropertyNode;
use PHPStan\Dependency\ExportedNode\ExportedTraitNode;
use PHPStan\Dependency\ExportedNode\ExportedTraitUseAdaptation;
use PHPStan\Type\FileTypeMapper;
class ExportedNodeResolver
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    /** @var Standard */
    private $printer;
    public function __construct(\PHPStan\Type\FileTypeMapper $fileTypeMapper, \PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->printer = $printer;
    }
    public function resolve(string $fileName, \PhpParser\Node $node) : ?\PHPStan\Dependency\ExportedNode
    {
        if ($node instanceof \PhpParser\Node\Stmt\Class_ && isset($node->namespacedName)) {
            $docComment = $node->getDocComment();
            $extendsName = null;
            if ($node->extends !== null) {
                $extendsName = $node->extends->toString();
            }
            $implementsNames = [];
            foreach ($node->implements as $className) {
                $implementsNames[] = $className->toString();
            }
            $usedTraits = [];
            $adaptations = [];
            foreach ($node->getTraitUses() as $traitUse) {
                foreach ($traitUse->traits as $usedTraitName) {
                    $usedTraits[] = $usedTraitName->toString();
                }
                foreach ($traitUse->adaptations as $adaptation) {
                    $adaptations[] = $adaptation;
                }
            }
            $className = $node->namespacedName->toString();
            return new \PHPStan\Dependency\ExportedNode\ExportedClassNode($className, $this->exportPhpDocNode($fileName, $className, null, $docComment !== null ? $docComment->getText() : null), $node->isAbstract(), $node->isFinal(), $extendsName, $implementsNames, $usedTraits, \array_map(static function (\PhpParser\Node\Stmt\TraitUseAdaptation $adaptation) : ExportedTraitUseAdaptation {
                if ($adaptation instanceof \PhpParser\Node\Stmt\TraitUseAdaptation\Alias) {
                    return \PHPStan\Dependency\ExportedNode\ExportedTraitUseAdaptation::createAlias($adaptation->trait !== null ? $adaptation->trait->toString() : null, $adaptation->method->toString(), $adaptation->newModifier, $adaptation->newName !== null ? $adaptation->newName->toString() : null);
                }
                if ($adaptation instanceof \PhpParser\Node\Stmt\TraitUseAdaptation\Precedence) {
                    return \PHPStan\Dependency\ExportedNode\ExportedTraitUseAdaptation::createPrecedence($adaptation->trait !== null ? $adaptation->trait->toString() : null, $adaptation->method->toString(), \array_map(static function (\PhpParser\Node\Name $name) : string {
                        return $name->toString();
                    }, $adaptation->insteadof));
                }
                throw new \PHPStan\ShouldNotHappenException();
            }, $adaptations));
        }
        if ($node instanceof \PhpParser\Node\Stmt\Interface_ && isset($node->namespacedName)) {
            $extendsNames = [];
            $docComment = $node->getDocComment();
            $interfaceName = $node->namespacedName->toString();
            return new \PHPStan\Dependency\ExportedNode\ExportedInterfaceNode($interfaceName, $this->exportPhpDocNode($fileName, $interfaceName, null, $docComment !== null ? $docComment->getText() : null), $extendsNames);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Trait_ && isset($node->namespacedName)) {
            return new \PHPStan\Dependency\ExportedNode\ExportedTraitNode($node->namespacedName->toString());
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            if ($node->isAbstract() || $node->isFinal() || !$node->isPrivate()) {
                $methodName = $node->name->toString();
                $docComment = $node->getDocComment();
                $parentNode = $node->getAttribute('parent');
                $continue = ($parentNode instanceof \PhpParser\Node\Stmt\Class_ || $parentNode instanceof \PhpParser\Node\Stmt\Interface_) && isset($parentNode->namespacedName);
                if (!$continue) {
                    return null;
                }
                return new \PHPStan\Dependency\ExportedNode\ExportedMethodNode($methodName, $this->exportPhpDocNode($fileName, $parentNode->namespacedName->toString(), $methodName, $docComment !== null ? $docComment->getText() : null), $node->byRef, $node->isPublic(), $node->isPrivate(), $node->isAbstract(), $node->isFinal(), $node->isStatic(), $this->printType($node->returnType), $this->exportParameterNodes($node->params));
            }
        }
        if ($node instanceof \PhpParser\Node\Stmt\PropertyProperty) {
            $parentNode = $node->getAttribute('parent');
            if (!$parentNode instanceof \PhpParser\Node\Stmt\Property) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            if ($parentNode->isPrivate()) {
                return null;
            }
            $classNode = $parentNode->getAttribute('parent');
            if (!$classNode instanceof \PhpParser\Node\Stmt\Class_ || !isset($classNode->namespacedName)) {
                return null;
            }
            $docComment = $parentNode->getDocComment();
            return new \PHPStan\Dependency\ExportedNode\ExportedPropertyNode($node->name->toString(), $this->exportPhpDocNode($fileName, $classNode->namespacedName->toString(), null, $docComment !== null ? $docComment->getText() : null), $this->printType($parentNode->type), $parentNode->isPublic(), $parentNode->isPrivate(), $parentNode->isStatic());
        }
        if ($node instanceof \PhpParser\Node\Const_) {
            $parentNode = $node->getAttribute('parent');
            if (!$parentNode instanceof \PhpParser\Node\Stmt\ClassConst) {
                return null;
            }
            if ($parentNode->isPrivate()) {
                return null;
            }
            return new \PHPStan\Dependency\ExportedNode\ExportedClassConstantNode($node->name->toString(), $this->printer->prettyPrintExpr($node->value), $parentNode->isPublic(), $parentNode->isPrivate());
        }
        if ($node instanceof \PhpParser\Node\Stmt\Function_) {
            $functionName = $node->name->name;
            if (isset($node->namespacedName)) {
                $functionName = (string) $node->namespacedName;
            }
            $docComment = $node->getDocComment();
            return new \PHPStan\Dependency\ExportedNode\ExportedFunctionNode($functionName, $this->exportPhpDocNode($fileName, null, $functionName, $docComment !== null ? $docComment->getText() : null), $node->byRef, $this->printType($node->returnType), $this->exportParameterNodes($node->params));
        }
        return null;
    }
    /**
     * @param Node\Identifier|Node\Name|Node\NullableType|Node\UnionType|null $type
     * @return string|null
     */
    private function printType($type) : ?string
    {
        if ($type === null) {
            return null;
        }
        if ($type instanceof \PhpParser\Node\NullableType) {
            return '?' . $this->printType($type->type);
        }
        if ($type instanceof \PhpParser\Node\UnionType) {
            return \implode('|', \array_map(function ($innerType) : string {
                $printedType = $this->printType($innerType);
                if ($printedType === null) {
                    throw new \PHPStan\ShouldNotHappenException();
                }
                return $printedType;
            }, $type->types));
        }
        return $type->toString();
    }
    /**
     * @param Node\Param[] $params
     * @return ExportedParameterNode[]
     */
    private function exportParameterNodes(array $params) : array
    {
        $nodes = [];
        foreach ($params as $param) {
            if (!$param->var instanceof \PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            $type = $param->type;
            if ($type !== null && $param->default instanceof \PhpParser\Node\Expr\ConstFetch && $param->default->name->toLowerString() === 'null') {
                if ($type instanceof \PhpParser\Node\UnionType) {
                    $innerTypes = $type->types;
                    $innerTypes[] = new \PhpParser\Node\Name('null');
                    $type = new \PhpParser\Node\UnionType($innerTypes);
                } elseif (!$type instanceof \PhpParser\Node\NullableType) {
                    $type = new \PhpParser\Node\NullableType($type);
                }
            }
            $nodes[] = new \PHPStan\Dependency\ExportedNode\ExportedParameterNode($param->var->name, $this->printType($type), $param->byRef, $param->variadic, $param->default !== null);
        }
        return $nodes;
    }
    private function exportPhpDocNode(string $file, ?string $className, ?string $functionName, ?string $text) : ?\PHPStan\Dependency\ExportedNode\ExportedPhpDocNode
    {
        if ($text === null) {
            return null;
        }
        $resolvedPhpDocBlock = $this->fileTypeMapper->getResolvedPhpDoc($file, $className, null, $functionName, $text);
        $nameScope = $resolvedPhpDocBlock->getNullableNameScope();
        if ($nameScope === null) {
            return null;
        }
        return new \PHPStan\Dependency\ExportedNode\ExportedPhpDocNode($text, $nameScope->getNamespace(), $nameScope->getUses());
    }
}
