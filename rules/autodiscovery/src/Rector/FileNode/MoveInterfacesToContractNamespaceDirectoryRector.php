<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Rector\FileNode;

use PhpParser\Node;
use PhpParser\Node\Stmt\Interface_;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\Rector\AbstractRector;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
use Rector\NetteToSymfony\NodeAnalyzer\NetteControlFactoryInterfaceAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * Inspiration @see https://github.com/rectorphp/rector/pull/1865/files#diff-0d18e660cdb626958662641b491623f8
 *
 * @see \Rector\Autodiscovery\Tests\Rector\FileNode\MoveInterfacesToContractNamespaceDirectoryRector\MoveInterfacesToContractNamespaceDirectoryRectorTest
 */
final class MoveInterfacesToContractNamespaceDirectoryRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var NetteControlFactoryInterfaceAnalyzer
     */
    private $netteControlFactoryInterfaceAnalyzer;
    /**
     * @var MovedFileWithNodesFactory
     */
    private $movedFileWithNodesFactory;
    public function __construct(\Rector\NetteToSymfony\NodeAnalyzer\NetteControlFactoryInterfaceAnalyzer $netteControlFactoryInterfaceAnalyzer, \Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory)
    {
        $this->netteControlFactoryInterfaceAnalyzer = $netteControlFactoryInterfaceAnalyzer;
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move interface to "Contract" namespace', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $interface = $this->betterNodeFinder->findFirstInstanceOf([$node], \PhpParser\Node\Stmt\Interface_::class);
        if (!$interface instanceof \PhpParser\Node\Stmt\Interface_) {
            return null;
        }
        if ($this->netteControlFactoryInterfaceAnalyzer->isComponentFactoryInterface($interface)) {
            return null;
        }
        $movedFileWithNodes = $this->movedFileWithNodesFactory->createWithDesiredGroup($node->getFileInfo(), $node->stmts, 'Contract');
        if (!$movedFileWithNodes instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithNodes) {
            return null;
        }
        $this->removedAndAddedFilesCollector->addMovedFile($movedFileWithNodes);
        return null;
    }
}
