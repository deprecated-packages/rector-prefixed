<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony5\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#httpfoundation
 * @see \Rector\Symfony5\Tests\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector\BinaryFileResponseCreateToNewInstanceRectorTest
 */
final class BinaryFileResponseCreateToNewInstanceRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change deprecated BinaryFileResponse::create() to use __construct() instead', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\HttpFoundation;

class SomeClass
{
    public function run()
    {
        $binaryFile = BinaryFileResponse::create();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\HttpFoundation;

class SomeClass
{
    public function run()
    {
        $binaryFile = new BinaryFileResponse(null);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$node->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return null;
        }
        if (!$this->isName($node->class, '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\BinaryFileResponse')) {
            return null;
        }
        if (!$this->isName($node->name, 'create')) {
            return null;
        }
        $args = $node->args;
        if ($args === []) {
            $args[] = $this->createArg($this->createNull());
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_($node->class, $args);
    }
}
