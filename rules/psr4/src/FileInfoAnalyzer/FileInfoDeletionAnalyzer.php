<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PSR4\FileInfoAnalyzer;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FileInfoDeletionAnalyzer
{
    /**
     * @see https://regex101.com/r/8BdrI3/1
     * @var string
     */
    private const TESTING_PREFIX_REGEX = '#input_(.*?)_#';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    public function isClassLikeAndFileInfoMatch(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        $className = $this->nodeNameResolver->getName($classLike);
        if ($className === null) {
            return \false;
        }
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $classLike->getAttribute(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo::class);
        $baseFileName = $this->clearNameFromTestingPrefix($smartFileInfo->getBasenameWithoutSuffix());
        $classShortName = $this->classNaming->getShortName($className);
        return $baseFileName === $classShortName;
    }
    public function clearNameFromTestingPrefix(string $name) : string
    {
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($name, self::TESTING_PREFIX_REGEX, '');
    }
}
