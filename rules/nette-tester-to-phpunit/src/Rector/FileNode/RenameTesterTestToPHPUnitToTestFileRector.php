<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\FileNode;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector\RenameTesterTestToPHPUnitToTestFileRectorTest
 */
final class RenameTesterTestToPHPUnitToTestFileRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename "*.phpt" file to "*Test.php" file', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $smartFileInfo = $node->getFileInfo();
        $oldRealPath = $smartFileInfo->getRealPath();
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($oldRealPath, '.phpt')) {
            return null;
        }
        $newRealPath = $this->createNewRealPath($oldRealPath);
        if ($newRealPath === $oldRealPath) {
            return null;
        }
        $movedFileWithContent = new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithContent($smartFileInfo, $newRealPath);
        $this->addMovedFile($movedFileWithContent);
        return null;
    }
    private function createNewRealPath(string $oldRealPath) : string
    {
        // file suffix
        $newRealPath = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($oldRealPath, self::PHPT_SUFFIX_REGEX, '.php');
        // Test suffix
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($newRealPath, 'Test.php')) {
            return \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($newRealPath, self::PHP_SUFFIX_REGEX, 'Test.php');
        }
        return $newRealPath;
    }
}
