<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\ClassMethod;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector\DateTimeToDateTimeInterfaceRectorTest
 */
final class DateTimeToDateTimeInterfaceRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const METHODS_RETURNING_CLASS_INSTANCE_MAP = ['add', 'modify', \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_STATE, 'setDate', 'setISODate', 'setTime', 'setTimestamp', 'setTimezone', 'sub'];
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes DateTime type-hint to DateTimeInterface', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass {
    public function methodWithDateTime(\DateTime $dateTime)
    {
        return true;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass {
    /**
     * @param \DateTime|\DateTimeImmutable $dateTime
     */
    public function methodWithDateTime(\DateTimeInterface $dateTime)
    {
        return true;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::DATE_TIME_INTERFACE)) {
            return null;
        }
        $isModifiedNode = \false;
        foreach ($node->getParams() as $param) {
            if (!$this->isDateTimeParam($param)) {
                continue;
            }
            $this->refactorParamTypeHint($param);
            $this->refactorParamDocBlock($param, $node);
            $this->refactorMethodCalls($param, $node);
            $isModifiedNode = \true;
        }
        if (!$isModifiedNode) {
            return null;
        }
        return $node;
    }
    private function isDateTimeParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
    {
        return $this->nodeTypeResolver->isObjectTypeOrNullableObjectType($param, \DateTime::class);
    }
    private function refactorParamTypeHint(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : void
    {
        $fullyQualified = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\DateTimeInterface::class);
        if ($param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            $param->type = new \_PhpScopere8e811afab72\PhpParser\Node\NullableType($fullyQualified);
            return;
        }
        $param->type = $fullyQualified;
    }
    private function refactorParamDocBlock(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classMethod);
        }
        $types = [new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTime::class), new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\DateTimeImmutable::class)];
        if ($param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        $paramName = $this->getName($param->var);
        if ($paramName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpDocInfo->changeParamType(new \_PhpScopere8e811afab72\PHPStan\Type\UnionType($types), $param, $paramName);
    }
    private function refactorMethodCalls(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->stmts === null) {
            return;
        }
        $this->traverseNodesWithCallable($classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($param) : void {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                return;
            }
            $this->refactorMethodCall($param, $node);
        });
    }
    private function refactorMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        $paramName = $this->getName($param->var);
        if ($paramName === null || $this->shouldSkipMethodCallRefactor($paramName, $methodCall)) {
            return;
        }
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($paramName), $methodCall);
        /** @var Node $parent */
        $parent = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            $parent->value = $assign;
            return;
        }
        if (!$parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return;
        }
        $parent->expr = $assign;
    }
    private function shouldSkipMethodCallRefactor(string $paramName, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isName($methodCall->var, $paramName)) {
            return \true;
        }
        if (!$this->isNames($methodCall->name, self::METHODS_RETURNING_CLASS_INSTANCE_MAP)) {
            return \true;
        }
        $parentNode = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            return \true;
        }
        return $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
    }
}
