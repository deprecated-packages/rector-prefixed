<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Rector\FileNode;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
/**
 * @see \Rector\FileSystemRector\Tests\Rector\FileNode\RemoveProjectFileRector\RemoveProjectFileRectorTest
 */
final class RemoveProjectFileRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove file relative to project directory', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::allString($filePathsToRemove);
        $this->filePathsToRemove = $filePathsToRemove;
    }
    private function isFilePathToRemove(string $relativePathInProject, string $filePathToRemove) : bool
    {
        if (\_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun() && \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($relativePathInProject, $filePathToRemove)) {
            // only for tests
            return \true;
        }
        return $relativePathInProject === $filePathToRemove;
    }
}
