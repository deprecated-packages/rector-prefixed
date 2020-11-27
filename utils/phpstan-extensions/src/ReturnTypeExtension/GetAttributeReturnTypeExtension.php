<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\ReturnTypeExtension;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Use_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPStanExtensions\Utils\PHPStanValueResolver;
use Symplify\SmartFileSystem\SmartFileInfo;
final class GetAttributeReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    /**
     * @var string[]|string[][]
     */
    private const ARGUMENT_KEY_TO_RETURN_TYPE = [
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::FILE_INFO' => \Symplify\SmartFileSystem\SmartFileInfo::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::RESOLVED_NAME' => \PhpParser\Node\Name::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::CLASS_NODE' => \PhpParser\Node\Stmt\ClassLike::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::METHOD_NODE' => \PhpParser\Node\Stmt\ClassMethod::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::CURRENT_EXPRESSION' => \PhpParser\Node\Stmt::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::PREVIOUS_STATEMENT' => \PhpParser\Node\Stmt::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::SCOPE' => \PHPStan\Analyser\Scope::class,
        # Node
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::ORIGINAL_NODE' => \PhpParser\Node::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::PARENT_NODE' => \PhpParser\Node::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::NEXT_NODE' => \PhpParser\Node::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::PREVIOUS_NODE' => \PhpParser\Node::class,
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::USE_NODES' => [\PhpParser\Node\Stmt\Use_::class],
        # scalars
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::PARENT_CLASS_NAME' => 'string',
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::NAMESPACE_NAME' => 'string',
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::CLASS_NAME' => 'string',
        \Rector\NodeTypeResolver\Node\AttributeKey::class . '::METHOD_NAME' => 'string',
    ];
    /**
     * @var PHPStanValueResolver
     */
    private $phpStanValueResolver;
    public function __construct(\Rector\PHPStanExtensions\Utils\PHPStanValueResolver $phpStanValueResolver)
    {
        $this->phpStanValueResolver = $phpStanValueResolver;
    }
    public function getClass() : string
    {
        return \PhpParser\Node::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getAttribute';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        $argumentValue = $this->resolveArgumentValue($methodCall->args[0]->value);
        if ($argumentValue === null) {
            return $returnType;
        }
        if (!isset(self::ARGUMENT_KEY_TO_RETURN_TYPE[$argumentValue])) {
            return $returnType;
        }
        $knownReturnType = self::ARGUMENT_KEY_TO_RETURN_TYPE[$argumentValue];
        if ($knownReturnType === 'string') {
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]);
        }
        if (\is_array($knownReturnType) && \count($knownReturnType) === 1) {
            $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\ObjectType($knownReturnType[0]));
            return new \PHPStan\Type\UnionType([$arrayType, new \PHPStan\Type\NullType()]);
        }
        if (\is_string($knownReturnType)) {
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType($knownReturnType), new \PHPStan\Type\NullType()]);
        }
        return $returnType;
    }
    private function resolveArgumentValue(\PhpParser\Node\Expr $expr) : ?string
    {
        if ($expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return $this->phpStanValueResolver->resolveClassConstFetch($expr);
        }
        return null;
    }
}
