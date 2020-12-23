<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PSR4\FileInfoAnalyzer;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    public function isClassLikeAndFileInfoMatch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        $className = $this->nodeNameResolver->getName($classLike);
        if ($className === null) {
            return \false;
        }
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $classLike->getAttribute(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo::class);
        $baseFileName = $this->clearNameFromTestingPrefix($smartFileInfo->getBasenameWithoutSuffix());
        $classShortName = $this->classNaming->getShortName($className);
        return $baseFileName === $classShortName;
    }
    public function clearNameFromTestingPrefix(string $name) : string
    {
        return \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($name, self::TESTING_PREFIX_REGEX, '');
    }
}
