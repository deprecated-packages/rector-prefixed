<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Rector\ClassLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithContent;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Restoration\Tests\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector\UpdateFileNameByClassNameFileSystemRectorTest
 */
final class UpdateFileNameByClassNameFileSystemRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename file to respect class name', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// app/SomeClass.php
class AnotherClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// app/AnotherClass.php
class AnotherClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike::class];
    }
    /**
     * @param ClassLike $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $className = $this->getName($node);
        if ($className === null) {
            return null;
        }
        $classShortName = $this->classNaming->getShortName($className);
        $smartFileInfo = $node->getAttribute(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo::class);
        if ($smartFileInfo === null) {
            return null;
        }
        // matches
        if ($classShortName === $smartFileInfo->getBasenameWithoutSuffix()) {
            return null;
        }
        // no match → rename file
        $newFileLocation = $smartFileInfo->getPath() . \DIRECTORY_SEPARATOR . $classShortName . '.php';
        $this->addMovedFile(new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithContent($smartFileInfo, $newFileLocation));
        return null;
    }
}
