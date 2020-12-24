<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Set;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a6b37af0871\Rector\Set\ValueObject\DowngradeSetList;
use _PhpScoper0a6b37af0871\Rector\Set\ValueObject\SetList;
use ReflectionClass;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject\Set;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorSetProvider extends \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Provider\AbstractSetProvider
{
    /**
     * @var string
     * @see https://regex101.com/r/8gO8w6/1
     */
    private const DASH_NUMBER_REGEX = '#\\-(\\d+)#';
    /**
     * @var Set[]
     */
    private $sets = [];
    public function __construct()
    {
        foreach ([\_PhpScoper0a6b37af0871\Rector\Set\ValueObject\SetList::class, \_PhpScoper0a6b37af0871\Rector\Set\ValueObject\DowngradeSetList::class] as $setListClass) {
            $setListReflectionClass = new \ReflectionClass($setListClass);
            $this->hydrateSetsFromConstants($setListReflectionClass);
        }
    }
    /**
     * @return Set[]
     */
    public function provide() : array
    {
        return $this->sets;
    }
    public function provideByName(string $desiredSetName) : ?\_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject\Set
    {
        $foundSet = parent::provideByName($desiredSetName);
        if ($foundSet instanceof \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject\Set) {
            return $foundSet;
        }
        // sencond approach by set path
        foreach ($this->sets as $set) {
            if (!\file_exists($desiredSetName)) {
                continue;
            }
            $desiredSetFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($desiredSetName);
            $setFileInfo = $set->getSetFileInfo();
            if ($setFileInfo->getRealPath() !== $desiredSetFileInfo->getRealPath()) {
                continue;
            }
            return $set;
        }
        $message = \sprintf('Set "%s" was not found', $desiredSetName);
        throw new \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $desiredSetName, $this->provideSetNames());
    }
    private function hydrateSetsFromConstants(\ReflectionClass $setListReflectionClass) : void
    {
        foreach ((array) $setListReflectionClass->getConstants() as $name => $setPath) {
            if (!\file_exists($setPath)) {
                $message = \sprintf('Set path "%s" was not found', $name);
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $setName = \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::constantToDashes($name);
            // remove `-` before numbers
            $setName = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($setName, self::DASH_NUMBER_REGEX, '$1');
            $this->sets[] = new \_PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject\Set($setName, new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($setPath));
        }
    }
}
