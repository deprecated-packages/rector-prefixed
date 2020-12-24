<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\FileNode;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://gnugat.github.io/2015/09/23/phpunit-with-phpspec.html
 *
 * @see \Rector\PhpSpecToPHPUnit\Tests\Rector\FileNode\RenameSpecFileToTestFileRector\RenameSpecFileToTestFileRectorTest
 */
final class RenameSpecFileToTestFileRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/r1VkPt/1
     */
    private const SPEC_REGEX = '#\\/spec\\/#';
    /**
     * @var string
     * @see https://regex101.com/r/WD4U43/1
     */
    private const SPEC_SUFFIX_REGEX = '#Spec\\.php$#';
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename "*Spec.php" file to "*Test.php" file', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// tests/SomeSpec.php
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// tests/SomeTest.php
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileNode::class];
    }
    /**
     * @param FileNode $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $fileInfo = $node->getFileInfo();
        $oldPathname = $fileInfo->getPathname();
        // ends with Spec.php
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($oldPathname, self::SPEC_SUFFIX_REGEX)) {
            return null;
        }
        $newPathName = $this->createPathName($oldPathname);
        $movedFileWithContent = new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\MovedFileWithContent($fileInfo, $newPathName);
        $this->addMovedFile($movedFileWithContent);
        return null;
    }
    private function createPathName(string $oldRealPath) : string
    {
        // suffix
        $newRealPath = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($oldRealPath, self::SPEC_SUFFIX_REGEX, 'Test.php');
        // directory
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($newRealPath, self::SPEC_REGEX, '/tests/');
    }
}
