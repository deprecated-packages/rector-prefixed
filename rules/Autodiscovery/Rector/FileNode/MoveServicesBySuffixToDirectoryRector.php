<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Rector\FileNode;

use RectorPrefix20210317\Nette\Utils\Strings;
use PhpParser\Node;
use Rector\Autodiscovery\FileLocation\ExpectedFileLocationResolver;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\Rector\AbstractRector;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210317\Webmozart\Assert\Assert;
/**
 * Inspiration @see https://github.com/rectorphp/rector/pull/1865/files#diff-0d18e660cdb626958662641b491623f8
 *
 * @see \Rector\Tests\Autodiscovery\Rector\FileNode\MoveServicesBySuffixToDirectoryRector\MoveServicesBySuffixToDirectoryRectorTest
 * @see \Rector\Tests\Autodiscovery\Rector\FileNode\MoveServicesBySuffixToDirectoryRector\MutualRenameTest
 */
final class MoveServicesBySuffixToDirectoryRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const GROUP_NAMES_BY_SUFFIX = 'group_names_by_suffix';
    /**
     * @var string[]
     */
    private $groupNamesBySuffix = [];
    /**
     * @var ExpectedFileLocationResolver
     */
    private $expectedFileLocationResolver;
    /**
     * @var MovedFileWithNodesFactory
     */
    private $movedFileWithNodesFactory;
    public function __construct(\Rector\Autodiscovery\FileLocation\ExpectedFileLocationResolver $expectedFileLocationResolver, \Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory)
    {
        $this->expectedFileLocationResolver = $expectedFileLocationResolver;
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move classes by their suffix to their own group/directory', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
// file: app/Entity/ProductRepository.php

namespace App/Entity;

class ProductRepository
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// file: app/Repository/ProductRepository.php

namespace App/Repository;

class ProductRepository
{
}
CODE_SAMPLE
, [self::GROUP_NAMES_BY_SUFFIX => ['Repository']])]);
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $classLikes = $this->betterNodeFinder->findClassLikes($node);
        if ($classLikes === []) {
            return null;
        }
        $this->processGroupNamesBySuffix($node->getFileInfo(), $node, $this->groupNamesBySuffix);
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure($configuration) : void
    {
        $groupNamesBySuffix = $configuration[self::GROUP_NAMES_BY_SUFFIX] ?? [];
        \RectorPrefix20210317\Webmozart\Assert\Assert::allString($groupNamesBySuffix);
        $this->groupNamesBySuffix = $groupNamesBySuffix;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * A. Match classes by suffix and move them to group namespace
     *
     * E.g. "App\Controller\SomeException"
     * ↓
     * "App\Exception\SomeException"
     *
     * @param string[] $groupNamesBySuffix
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     * @param \Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode
     */
    private function processGroupNamesBySuffix($smartFileInfo, $fileNode, $groupNamesBySuffix) : void
    {
        foreach ($groupNamesBySuffix as $groupNames) {
            // has class suffix
            $suffixPattern = '\\w+' . $groupNames . '(Test)?\\.php$';
            if (!\RectorPrefix20210317\Nette\Utils\Strings::match($smartFileInfo->getRealPath(), '#' . $suffixPattern . '#')) {
                continue;
            }
            if ($this->isLocatedInExpectedLocation($groupNames, $suffixPattern, $smartFileInfo)) {
                continue;
            }
            // file is already in the group
            if (\RectorPrefix20210317\Nette\Utils\Strings::match($smartFileInfo->getPath(), '#' . $groupNames . '$#')) {
                continue;
            }
            $this->moveFileToGroupName($smartFileInfo, $fileNode, $groupNames);
            return;
        }
    }
    /**
     * @param string $groupName
     * @param string $suffixPattern
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     */
    private function isLocatedInExpectedLocation($groupName, $suffixPattern, $smartFileInfo) : bool
    {
        $expectedLocationFilePattern = $this->expectedFileLocationResolver->resolve($groupName, $suffixPattern);
        return (bool) \RectorPrefix20210317\Nette\Utils\Strings::match($smartFileInfo->getRealPath(), $expectedLocationFilePattern);
    }
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo $fileInfo
     * @param \Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode
     * @param string $desiredGroupName
     */
    private function moveFileToGroupName($fileInfo, $fileNode, $desiredGroupName) : void
    {
        $movedFileWithNodes = $this->movedFileWithNodesFactory->createWithDesiredGroup($fileInfo, $fileNode->stmts, $desiredGroupName);
        if (!$movedFileWithNodes instanceof \Rector\FileSystemRector\ValueObject\MovedFileWithNodes) {
            return;
        }
        $this->removedAndAddedFilesCollector->addMovedFile($movedFileWithNodes);
    }
}
