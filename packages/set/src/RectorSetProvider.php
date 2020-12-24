<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Set;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
use _PhpScoperb75b35f52b74\Rector\Set\ValueObject\DowngradeSetList;
use _PhpScoperb75b35f52b74\Rector\Set\ValueObject\SetList;
use ReflectionClass;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorSetProvider extends \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Provider\AbstractSetProvider
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
        foreach ([\_PhpScoperb75b35f52b74\Rector\Set\ValueObject\SetList::class, \_PhpScoperb75b35f52b74\Rector\Set\ValueObject\DowngradeSetList::class] as $setListClass) {
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
    public function provideByName(string $desiredSetName) : ?\_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set
    {
        $foundSet = parent::provideByName($desiredSetName);
        if ($foundSet instanceof \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set) {
            return $foundSet;
        }
        // sencond approach by set path
        foreach ($this->sets as $set) {
            if (!\file_exists($desiredSetName)) {
                continue;
            }
            $desiredSetFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($desiredSetName);
            $setFileInfo = $set->getSetFileInfo();
            if ($setFileInfo->getRealPath() !== $desiredSetFileInfo->getRealPath()) {
                continue;
            }
            return $set;
        }
        $message = \sprintf('Set "%s" was not found', $desiredSetName);
        throw new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $desiredSetName, $this->provideSetNames());
    }
    private function hydrateSetsFromConstants(\ReflectionClass $setListReflectionClass) : void
    {
        foreach ((array) $setListReflectionClass->getConstants() as $name => $setPath) {
            if (!\file_exists($setPath)) {
                $message = \sprintf('Set path "%s" was not found', $name);
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $setName = \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::constantToDashes($name);
            // remove `-` before numbers
            $setName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($setName, self::DASH_NUMBER_REGEX, '$1');
            $this->sets[] = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\ValueObject\Set($setName, new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($setPath));
        }
    }
}
