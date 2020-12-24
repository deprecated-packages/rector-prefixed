<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\Interface_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector\DeleteFactoryInterfaceFileSystemRectorTest
 */
final class DeleteFactoryInterfaceRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NetteControlFactoryInterfaceAnalyzer
     */
    private $netteControlFactoryInterfaceAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer $netteControlFactoryInterfaceAnalyzer)
    {
        $this->netteControlFactoryInterfaceAnalyzer = $netteControlFactoryInterfaceAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Interface factories are not needed in Symfony. Clear constructor injection is used instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Interface_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $smartFileInfo = $node->getAttribute(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo::class);
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
