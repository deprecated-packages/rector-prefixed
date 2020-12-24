<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteTesterToPHPUnit\Rector\FileNode;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector\RenameTesterTestToPHPUnitToTestFileRectorTest
 */
final class RenameTesterTestToPHPUnitToTestFileRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
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
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename "*.phpt" file to "*Test.php" file', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// tests/SomeTestCase.phpt
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// tests/SomeTestCase.php
CODE_SAMPLE
)]);
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
        $smartFileInfo = $node->getFileInfo();
        $oldRealPath = $smartFileInfo->getRealPath();
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($oldRealPath, '.phpt')) {
            return null;
        }
        $newRealPath = $this->createNewRealPath($oldRealPath);
        if ($newRealPath === $oldRealPath) {
            return null;
        }
        $movedFileWithContent = new \_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObject\MovedFileWithContent($smartFileInfo, $newRealPath);
        $this->addMovedFile($movedFileWithContent);
        return null;
    }
    private function createNewRealPath(string $oldRealPath) : string
    {
        // file suffix
        $newRealPath = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::replace($oldRealPath, self::PHPT_SUFFIX_REGEX, '.php');
        // Test suffix
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($newRealPath, 'Test.php')) {
            return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::replace($newRealPath, self::PHP_SUFFIX_REGEX, 'Test.php');
        }
        return $newRealPath;
    }
}
