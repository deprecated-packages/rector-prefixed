<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Double;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Object_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/5577003/using-settype-in-php-instead-of-typecasting-using-brackets-what-is-the-differen/5577068#5577068
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/3709
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\SetTypeToCastRector\SetTypeToCastRectorTest
 */
final class SetTypeToCastRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const TYPE_TO_CAST = ['array' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Array_::class, 'bool' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_::class, 'boolean' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_::class, 'double' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Double::class, 'float' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Double::class, 'int' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_::class, 'integer' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_::class, 'object' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Object_::class, 'string' => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\String_::class];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes settype() to (type) where possible', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // result of function or probably used
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr || $parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Arg) {
            return null;
        }
        if (isset(self::TYPE_TO_CAST[$typeNode])) {
            $castClass = self::TYPE_TO_CAST[$typeNode];
            $castNode = new $castClass($varNode);
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                // bare expression? → assign
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($varNode, $castNode);
            }
            return $castNode;
        }
        if ($typeNode === 'null') {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($varNode, $this->createNull());
        }
        return $node;
    }
}
