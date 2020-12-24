<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Autodiscovery\Rector\FileNode;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Autodiscovery\FileLocation\ExpectedFileLocationResolver;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * Inspiration @see https://github.com/rectorphp/rector/pull/1865/files#diff-0d18e660cdb626958662641b491623f8
 *
 * @see \Rector\Autodiscovery\Tests\Rector\FileNode\MoveServicesBySuffixToDirectoryRector\MoveServicesBySuffixToDirectoryRectorTest
 * @see \Rector\Autodiscovery\Tests\Rector\FileNode\MoveServicesBySuffixToDirectoryRector\MutualRenameTest
 */
final class MoveServicesBySuffixToDirectoryRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Autodiscovery\FileLocation\ExpectedFileLocationResolver $expectedFileLocationResolver)
    {
        $this->expectedFileLocationResolver = $expectedFileLocationResolver;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move classes by their suffix to their own group/directory', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
     * @param FileNode $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $classLikes = $this->betterNodeFinder->findClassLikes($node);
        if ($classLikes === []) {
            return null;
        }
        $this->processGroupNamesBySuffix($node->getFileInfo(), $node, $this->groupNamesBySuffix);
        return null;
    }
    public function configure(array $configuration) : void
    {
        $groupNamesBySuffix = $configuration[self::GROUP_NAMES_BY_SUFFIX] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allString($groupNamesBySuffix);
        $this->groupNamesBySuffix = $groupNamesBySuffix;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * A. Match classes by suffix and move them to group namespace
     *
     * E.g. "App\Controller\SomeException"
     * ↓
     * "App\Exception\SomeException"
     *
     * @param string[] $groupNamesBySuffix
     */
    private function processGroupNamesBySuffix(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode, array $groupNamesBySuffix) : void
    {
        foreach ($groupNamesBySuffix as $groupName) {
            // has class suffix
            $suffixPattern = '\\w+' . $groupName . '(Test)?\\.php$';
            if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($smartFileInfo->getRealPath(), '#' . $suffixPattern . '#')) {
                continue;
            }
            if ($this->isLocatedInExpectedLocation($groupName, $suffixPattern, $smartFileInfo)) {
                continue;
            }
            // file is already in the group
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($smartFileInfo->getPath(), '#' . $groupName . '$#')) {
                continue;
            }
            $this->moveFileToGroupName($smartFileInfo, $fileNode, $groupName);
            return;
        }
    }
    private function isLocatedInExpectedLocation(string $groupName, string $suffixPattern, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        $expectedLocationFilePattern = $this->expectedFileLocationResolver->resolve($groupName, $suffixPattern);
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($smartFileInfo->getRealPath(), $expectedLocationFilePattern);
    }
    private function moveFileToGroupName(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode, string $desiredGroupName) : void
    {
        $movedFileWithNodes = $this->movedFileWithNodesFactory->createWithDesiredGroup($fileInfo, $fileNode->stmts, $desiredGroupName);
        if ($movedFileWithNodes === null) {
            return;
        }
        $this->addMovedFile($movedFileWithNodes);
    }
}
