<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony5\Rector\StaticCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#httpfoundation
 * @see \Rector\Symfony5\Tests\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector\BinaryFileResponseCreateToNewInstanceRectorTest
 */
final class BinaryFileResponseCreateToNewInstanceRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change deprecated BinaryFileResponse::create() to use __construct() instead', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return null;
        }
        if (!$this->isName($node->class, '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\BinaryFileResponse')) {
            return null;
        }
        if (!$this->isName($node->name, 'create')) {
            return null;
        }
        $args = $node->args;
        if ($args === []) {
            $args[] = $this->createArg($this->createNull());
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_($node->class, $args);
    }
}
