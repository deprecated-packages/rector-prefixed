<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php72\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/manual/en/migration72.incompatible.php#migration72.incompatible.is_object-on-incomplete_class
 * @see https://3v4l.org/SpiE6
 *
 * @see \Rector\Php72\Tests\Rector\FuncCall\IsObjectOnIncompleteClassRector\IsObjectOnIncompleteClassRectorTest
 */
final class IsObjectOnIncompleteClassRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Incomplete class returns inverted bool on is_object()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$incompleteObject = new __PHP_Incomplete_Class;
$isObject = is_object($incompleteObject);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$incompleteObject = new __PHP_Incomplete_Class;
$isObject = ! is_object($incompleteObject);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node, 'is_object')) {
            return null;
        }
        $incompleteClassObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType('__PHP_Incomplete_Class');
        if (!$this->isObjectType($node->args[0]->value, $incompleteClassObjectType)) {
            return null;
        }
        if ($this->shouldSkip($node)) {
            return null;
        }
        $booleanNot = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($node);
        $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $booleanNot);
        return $booleanNot;
    }
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $parentNode = $funcCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        return $parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
    }
}
