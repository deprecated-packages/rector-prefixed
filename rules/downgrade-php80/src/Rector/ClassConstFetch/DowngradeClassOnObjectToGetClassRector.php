<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp80\Rector\ClassConstFetch;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\ClassConstFetch\DowngradeClassOnObjectToGetClassRector\DowngradeClassOnObjectToGetClassRectorTest
 */
final class DowngradeClassOnObjectToGetClassRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $object::class to get_class($object)', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($object)
    {
        return $object::class;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($object)
    {
        return get_class($object);
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isName($node->name, 'class')) {
            return null;
        }
        if (!$node->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return null;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('get_class'), [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($node->class)]);
    }
}
