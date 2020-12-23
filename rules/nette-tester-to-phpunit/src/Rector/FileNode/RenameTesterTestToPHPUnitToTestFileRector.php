<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteTesterToPHPUnit\Rector\FileNode;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector\RenameTesterTestToPHPUnitToTestFileRectorTest
 */
final class RenameTesterTestToPHPUnitToTestFileRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
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
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename "*.phpt" file to "*Test.php" file', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $smartFileInfo = $node->getFileInfo();
        $oldRealPath = $smartFileInfo->getRealPath();
        if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($oldRealPath, '.phpt')) {
            return null;
        }
        $newRealPath = $this->createNewRealPath($oldRealPath);
        if ($newRealPath === $oldRealPath) {
            return null;
        }
        $movedFileWithContent = new \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithContent($smartFileInfo, $newRealPath);
        $this->addMovedFile($movedFileWithContent);
        return null;
    }
    private function createNewRealPath(string $oldRealPath) : string
    {
        // file suffix
        $newRealPath = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($oldRealPath, self::PHPT_SUFFIX_REGEX, '.php');
        // Test suffix
        if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($newRealPath, 'Test.php')) {
            return \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($newRealPath, self::PHP_SUFFIX_REGEX, 'Test.php');
        }
        return $newRealPath;
    }
}
