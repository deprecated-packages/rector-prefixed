<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Rector\Interface_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector\DeleteFactoryInterfaceFileSystemRectorTest
 */
final class DeleteFactoryInterfaceRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NetteControlFactoryInterfaceAnalyzer
     */
    private $netteControlFactoryInterfaceAnalyzer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer $netteControlFactoryInterfaceAnalyzer)
    {
        $this->netteControlFactoryInterfaceAnalyzer = $netteControlFactoryInterfaceAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Interface factories are not needed in Symfony. Clear constructor injection is used instead', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
interface SomeControlFactoryInterface
{
    public function create();
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Interface_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $smartFileInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo::class);
        if ($smartFileInfo === null) {
            return null;
        }
        if (!$this->netteControlFactoryInterfaceAnalyzer->isComponentFactoryInterface($node)) {
            return null;
        }
        $this->removeFile($smartFileInfo);
        return null;
    }
}
