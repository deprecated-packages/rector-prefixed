<?php

declare (strict_types=1);
namespace Rector\NetteTesterToPHPUnit\Rector\FileNode;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\Rector\AbstractRector;
use Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector\RenameTesterTestToPHPUnitToTestFileRectorTest
 */
final class RenameTesterTestToPHPUnitToTestFileRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/ioamnE/1
     */
    private const PHP_SUFFIX_REGEX = '#\\.php$#';
    /**
     * @var string
     * @see https://regex101.com/r/cOMZIj/1
     */
    private const PHPT_SUFFIX_REGEX = '#\\.phpt$#';
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename "*.phpt" file to "*Test.php" file', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// tests/SomeTestCase.phpt
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// tests/SomeTestCase.php
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
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
        $smartFileInfo = $node->getFileInfo();
        $oldRealPath = $smartFileInfo->getRealPath();
        if (!\RectorPrefix20210408\Nette\Utils\Strings::endsWith($oldRealPath, '.phpt')) {
            return null;
        }
        $newRealPath = $this->createNewRealPath($oldRealPath);
        if ($newRealPath === $oldRealPath) {
            return null;
        }
        $movedFileWithContent = new \Rector\FileSystemRector\ValueObject\MovedFileWithContent($smartFileInfo, $newRealPath);
        $this->removedAndAddedFilesCollector->addMovedFile($movedFileWithContent);
        return null;
    }
    private function createNewRealPath(string $oldRealPath) : string
    {
        // file suffix
        $newRealPath = \RectorPrefix20210408\Nette\Utils\Strings::replace($oldRealPath, self::PHPT_SUFFIX_REGEX, '.php');
        // Test suffix
        if (!\RectorPrefix20210408\Nette\Utils\Strings::endsWith($newRealPath, 'Test.php')) {
            return \RectorPrefix20210408\Nette\Utils\Strings::replace($newRealPath, self::PHP_SUFFIX_REGEX, 'Test.php');
        }
        return $newRealPath;
    }
}
