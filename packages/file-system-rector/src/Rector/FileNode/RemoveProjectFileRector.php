<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\FileSystemRector\Rector\FileNode;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\FileSystemRector\Tests\Rector\FileNode\RemoveProjectFileRector\RemoveProjectFileRectorTest
 */
final class RemoveProjectFileRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const FILE_PATHS_TO_REMOVE = 'file_paths_to_remove';
    /**
     * @var string[]
     */
    private $filePathsToRemove = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove file relative to project directory', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
// someFile/ToBeRemoved.txt
CODE_SAMPLE
, <<<'CODE_SAMPLE'
CODE_SAMPLE
, [self::FILE_PATHS_TO_REMOVE => ['someFile/ToBeRemoved.txt']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->filePathsToRemove === []) {
            return null;
        }
        $projectDirectory = \getcwd();
        $smartFileInfo = $node->getFileInfo();
        $relativePathInProject = $smartFileInfo->getRelativeFilePathFromDirectory($projectDirectory);
        foreach ($this->filePathsToRemove as $filePathsToRemove) {
            if (!$this->isFilePathToRemove($relativePathInProject, $filePathsToRemove)) {
                continue;
            }
            $this->removeFile($smartFileInfo);
        }
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $filePathsToRemove = $configuration[self::FILE_PATHS_TO_REMOVE] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allString($filePathsToRemove);
        $this->filePathsToRemove = $filePathsToRemove;
    }
    private function isFilePathToRemove(string $relativePathInProject, string $filePathToRemove) : bool
    {
        if (\_PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun() && \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($relativePathInProject, $filePathToRemove)) {
            // only for tests
            return \true;
        }
        return $relativePathInProject === $filePathToRemove;
    }
}
