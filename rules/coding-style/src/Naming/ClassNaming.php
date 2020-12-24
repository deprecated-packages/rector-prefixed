<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Naming;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassNaming
{
    /**
     * @see https://regex101.com/r/8BdrI3/1
     * @var string
     */
    private const INPUT_HASH_NAMING_REGEX = '#input_(.*?)_#';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param string|Name|Identifier $name
     */
    public function getVariableName($name) : string
    {
        $shortName = $this->getShortName($name);
        return \lcfirst($shortName);
    }
    /**
     * @param string|Name|Identifier|ClassLike $name
     */
    public function getShortName($name) : string
    {
        if ($name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike) {
            if ($name->name === null) {
                return '';
            }
            return $this->getShortName($name->name);
        }
        if ($name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name || $name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            $name = $this->nodeNameResolver->getName($name);
            if ($name === null) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
        }
        $name = \trim($name, '\\');
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($name, '\\', -1) ?: $name;
    }
    public function getNamespace(string $fullyQualifiedName) : ?string
    {
        $fullyQualifiedName = \trim($fullyQualifiedName, '\\');
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::before($fullyQualifiedName, '\\', -1) ?: null;
    }
    public function getNameFromFileInfo(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $basenameWithoutSuffix = $smartFileInfo->getBasenameWithoutSuffix();
        // remove PHPUnit fixture file prefix
        if (\_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $basenameWithoutSuffix = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($basenameWithoutSuffix, self::INPUT_HASH_NAMING_REGEX, '');
        }
        return \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($basenameWithoutSuffix);
    }
    /**
     * "some_function" → "someFunction"
     */
    public function createMethodNameFromFunction(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_ $function) : string
    {
        $functionName = (string) $function->name;
        return \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($functionName);
    }
}
