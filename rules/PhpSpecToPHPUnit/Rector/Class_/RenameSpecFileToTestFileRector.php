<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\Rector\Class_;

use RectorPrefix20210420\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Rector\AbstractRector;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://gnugat.github.io/2015/09/23/phpunit-with-phpspec.html
 *
 * @see \Rector\Tests\PhpSpecToPHPUnit\Rector\Class_\RenameSpecFileToTestFileRector\RenameSpecFileToTestFileRectorTest
 */
final class RenameSpecFileToTestFileRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/r1VkPt/1
     */
    const SPEC_REGEX = '#\\/spec\\/#';
    /**
     * @var string
     * @see https://regex101.com/r/WD4U43/1
     */
    const SPEC_SUFFIX_REGEX = '#Spec\\.php$#';
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename "*Spec.php" file to "*Test.php" file', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// tests/SomeSpec.php
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// tests/SomeTest.php
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        $smartFileInfo = $this->file->getSmartFileInfo();
        $oldPathname = $smartFileInfo->getPathname();
        // ends with Spec.php
        if (!\RectorPrefix20210420\Nette\Utils\Strings::match($oldPathname, self::SPEC_SUFFIX_REGEX)) {
            return null;
        }
        $this->removedAndAddedFilesCollector->removeFile($smartFileInfo);
        $newPathName = $this->createPathName($oldPathname);
        $addedFileWithContent = new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($newPathName, $smartFileInfo->getContents());
        $this->removedAndAddedFilesCollector->addAddedFile($addedFileWithContent);
        return null;
    }
    private function createPathName(string $oldRealPath) : string
    {
        // suffix
        $newRealPath = \RectorPrefix20210420\Nette\Utils\Strings::replace($oldRealPath, self::SPEC_SUFFIX_REGEX, 'Test.php');
        // directory
        return \RectorPrefix20210420\Nette\Utils\Strings::replace($newRealPath, self::SPEC_REGEX, '/tests/');
    }
}
