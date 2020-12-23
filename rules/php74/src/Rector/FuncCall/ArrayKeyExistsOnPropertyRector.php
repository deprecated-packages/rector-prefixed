<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php74\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/deprecations_php_7_4 (not confirmed yet)
 * @see https://3v4l.org/69mpd
 * @see \Rector\Php74\Tests\Rector\FuncCall\ArrayKeyExistsOnPropertyRector\ArrayKeyExistsOnPropertyRectorTest
 */
final class ArrayKeyExistsOnPropertyRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array_key_exists() on property to property_exists()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
     public $value;
}
$someClass = new SomeClass;

array_key_exists('value', $someClass);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
     public $value;
}
$someClass = new SomeClass;

property_exists($someClass, 'value');
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
        if (!$this->isName($node, 'array_key_exists')) {
            return null;
        }
        if (!$this->getStaticType($node->args[1]->value) instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
            return null;
        }
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('property_exists');
        $node->args = \array_reverse($node->args);
        return $node;
    }
}
