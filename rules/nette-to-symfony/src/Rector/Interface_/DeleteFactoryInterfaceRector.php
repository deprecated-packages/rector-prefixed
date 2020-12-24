<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\Interface_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\NetteToSymfony\Tests\Rector\Interface_\DeleteFactoryInterfaceRector\DeleteFactoryInterfaceFileSystemRectorTest
 */
final class DeleteFactoryInterfaceRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NetteControlFactoryInterfaceAnalyzer
     */
    private $netteControlFactoryInterfaceAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer $netteControlFactoryInterfaceAnalyzer)
    {
        $this->netteControlFactoryInterfaceAnalyzer = $netteControlFactoryInterfaceAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Interface factories are not needed in Symfony. Clear constructor injection is used instead', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Interface_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $smartFileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo::class);
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
