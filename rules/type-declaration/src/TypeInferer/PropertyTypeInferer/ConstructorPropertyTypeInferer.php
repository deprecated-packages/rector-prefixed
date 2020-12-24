<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassMethodPropertyFetchManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class ConstructorPropertyTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var ClassMethodPropertyFetchManipulator
     */
    private $classMethodPropertyFetchManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassMethodPropertyFetchManipulator $classMethodPropertyFetchManipulator)
    {
        $this->classMethodPropertyFetchManipulator = $classMethodPropertyFetchManipulator;
    }
    public function inferProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $classMethod = $classLike->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($classMethod === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $propertyName = $this->nodeNameResolver->getName($property);
        $param = $this->classMethodPropertyFetchManipulator->resolveParamForPropertyFetch($classMethod, $propertyName);
        if ($param === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        // A. infer from type declaration of parameter
        if ($param->type !== null) {
            return $this->resolveFromParamType($param, $classMethod, $propertyName);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 800;
    }
    private function resolveFromParamType(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->resolveParamTypeToPHPStanType($param);
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $types = [];
        // it's an array - annotation → make type more precise, if possible
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            $types[] = $this->getResolveParamStaticTypeAsPHPStanType($classMethod, $propertyName);
        } else {
            $types[] = $type;
        }
        if ($this->isParamNullable($param)) {
            $types[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    private function resolveParamTypeToPHPStanType(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($param->type === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            $types = [];
            $types[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
            $types[] = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type->type);
            return $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        // special case for alias
        if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified) {
            $type = $this->resolveFullyQualifiedOrAliasedObjectType($param);
            if ($type !== null) {
                return $type;
            }
        }
        return $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
    }
    private function getResolveParamStaticTypeAsPHPStanType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $paramStaticType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyName, &$paramStaticType) : ?int {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, $propertyName)) {
                return null;
            }
            $paramStaticType = $this->nodeTypeResolver->getStaticType($node);
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $paramStaticType;
    }
    private function isParamNullable(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : bool
    {
        if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            return \true;
        }
        if ($param->default !== null) {
            $defaultValueStaticType = $this->nodeTypeResolver->getStaticType($param->default);
            if ($defaultValueStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
                return \true;
            }
        }
        return \false;
    }
    private function resolveFullyQualifiedOrAliasedObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($param->type === null) {
            return null;
        }
        $fullyQualifiedName = $this->nodeNameResolver->getName($param->type);
        if (!$fullyQualifiedName) {
            return null;
        }
        $originalName = $param->type->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
        if (!$originalName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return null;
        }
        // if the FQN has different ending than the original, it was aliased and we need to return the alias
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($fullyQualifiedName, '\\' . $originalName->toString())) {
            $className = $originalName->toString();
            if (\class_exists($className)) {
                return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($className);
            }
            // @note: $fullyQualifiedName is a guess, needs real life test
            return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType($originalName->toString(), $fullyQualifiedName);
        }
        return null;
    }
}
