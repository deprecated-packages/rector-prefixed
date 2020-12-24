<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Autodiscovery\Rector\FileNode;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Analyzer\NetteControlFactoryInterfaceAnalyzer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * Inspiration @see https://github.com/rectorphp/rector/pull/1865/files#diff-0d18e660cdb626958662641b491623f8
 *
 * @see \Rector\Autodiscovery\Tests\Rector\FileNode\MoveInterfacesToContractNamespaceDirectoryRector\MoveInterfacesToContractNamespaceDirectoryRectorTest
 */
final class MoveInterfacesToContractNamespaceDirectoryRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move interface to "Contract" namespace', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// file: app/Exception/Rule.php

namespace App\Exception;

interface Rule
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// file: app/Contract/Rule.php

namespace App\Contract;

interface Rule
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        /** @var Interface_|null $interface */
        $interface = $this->betterNodeFinder->findFirstInstanceOf([$node], \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_::class);
        if ($interface === null) {
            return null;
        }
        if ($this->netteControlFactoryInterfaceAnalyzer->isComponentFactoryInterface($interface)) {
            return null;
        }
        $movedFileWithNodes = $this->movedFileWithNodesFactory->createWithDesiredGroup($node->getFileInfo(), $node->stmts, 'Contract');
        if ($movedFileWithNodes === null) {
            return null;
        }
        $this->addMovedFile($movedFileWithNodes);
        return null;
    }
}
