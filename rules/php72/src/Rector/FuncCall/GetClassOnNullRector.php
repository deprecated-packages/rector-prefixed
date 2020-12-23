<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php72\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/manual/en/migration72.incompatible.php#migration72.incompatible.no-null-to-get_class
 * @see https://3v4l.org/sk0fp
 * @see \Rector\Php72\Tests\Rector\FuncCall\GetClassOnNullRector\GetClassOnNullRectorTest
 */
final class GetClassOnNullRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Null is no more allowed in get_class()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function getItem()
    {
        $value = null;
        return get_class($value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function getItem()
    {
        $value = null;
        return $value !== null ? get_class($value) : self::class;
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isName($node, 'get_class')) {
            return null;
        }
        // only relevant inside the class
        /** @var Scope|null $nodeScope */
        $nodeScope = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope instanceof \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope && !$nodeScope->isInClass()) {
            return null;
        }
        // possibly already changed
        if ($this->shouldSkip($node)) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $valueNode = $node->args[0]->value;
        if (!$this->isNullableType($valueNode) && !$this->isStaticType($valueNode, \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType::class)) {
            return null;
        }
        $notIdentical = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($valueNode, $this->createNull());
        $funcCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall($node->name, $node->args);
        $selfClassConstFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('self'), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('class'));
        $ternary = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary($notIdentical, $funcCall, $selfClassConstFetch);
        $funcCall->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $ternary);
        return $ternary;
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $classLike = $funcCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_) {
            return \true;
        }
        $parentNode = $funcCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary) {
            return \false;
        }
        if ($this->isIdenticalToNotNull($funcCall, $parentNode)) {
            return \true;
        }
        return $this->isNotIdenticalToNull($funcCall, $parentNode);
    }
    /**
     * E.g. "$value === [!null] ? get_class($value)"
     */
    private function isIdenticalToNotNull(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        if (!$ternary->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
            return \false;
        }
        if ($this->areNodesEqual($ternary->cond->left, $funcCall->args[0]->value) && !$this->isNull($ternary->cond->right)) {
            return \true;
        }
        if (!$this->areNodesEqual($ternary->cond->right, $funcCall->args[0]->value)) {
            return \false;
        }
        return !$this->isNull($ternary->cond->left);
    }
    /**
     * E.g. "$value !== null ? get_class($value)"
     */
    private function isNotIdenticalToNull(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        if (!$ternary->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return \false;
        }
        if ($this->areNodesEqual($ternary->cond->left, $funcCall->args[0]->value) && $this->isNull($ternary->cond->right)) {
            return \true;
        }
        if (!$this->areNodesEqual($ternary->cond->right, $funcCall->args[0]->value)) {
            return \false;
        }
        return $this->isNull($ternary->cond->left);
    }
}
