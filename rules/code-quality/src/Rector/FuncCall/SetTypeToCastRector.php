<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Double;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Int_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Object_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\String_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/5577003/using-settype-in-php-instead-of-typecasting-using-brackets-what-is-the-differen/5577068#5577068
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/3709
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\SetTypeToCastRector\SetTypeToCastRectorTest
 */
final class SetTypeToCastRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const TYPE_TO_CAST = ['array' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_::class, 'bool' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_::class, 'boolean' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_::class, 'double' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Double::class, 'float' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Double::class, 'int' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Int_::class, 'integer' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Int_::class, 'object' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Object_::class, 'string' => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\String_::class];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes settype() to (type) where possible', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($foo)
    {
        settype($foo, 'string');

        return settype($foo, 'integer');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(array $items)
    {
        $foo = (string) $foo;

        return (int) $foo;
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isName($node, 'settype')) {
            return null;
        }
        $typeNode = $this->getValue($node->args[1]->value);
        if ($typeNode === null) {
            return null;
        }
        $typeNode = \strtolower($typeNode);
        $varNode = $node->args[0]->value;
        $parentNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // result of function or probably used
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr) {
            return null;
        }
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg) {
            return null;
        }
        if (isset(self::TYPE_TO_CAST[$typeNode])) {
            $castClass = self::TYPE_TO_CAST[$typeNode];
            $castNode = new $castClass($varNode);
            if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
                // bare expression? → assign
                return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($varNode, $castNode);
            }
            return $castNode;
        }
        if ($typeNode === 'null') {
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($varNode, $this->createNull());
        }
        return $node;
    }
}
