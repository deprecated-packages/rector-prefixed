<?php

declare (strict_types=1);
namespace Rector\FileSystemRector\Rector\FileNode;

use _PhpScoperf18a0c41e2d2\Nette\Utils\Strings;
use PhpParser\Node;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperf18a0c41e2d2\Webmozart\Assert\Assert;
/**
 * @see \Rector\FileSystemRector\Tests\Rector\FileNode\RemoveProjectFileRector\RemoveProjectFileRectorTest
 */
final class RemoveProjectFileRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove file relative to project directory', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
        \_PhpScoperf18a0c41e2d2\Webmozart\Assert\Assert::allString($filePathsToRemove);
        $this->filePathsToRemove = $filePathsToRemove;
    }
    private function isFilePathToRemove(string $relativePathInProject, string $filePathToRemove) : bool
    {
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun() && \_PhpScoperf18a0c41e2d2\Nette\Utils\Strings::endsWith($relativePathInProject, $filePathToRemove)) {
            // only for tests
            return \true;
        }
        return $relativePathInProject === $filePathToRemove;
    }
}
