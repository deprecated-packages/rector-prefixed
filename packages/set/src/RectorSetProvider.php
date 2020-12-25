<?php

declare (strict_types=1);
namespace Rector\Set;

use _PhpScoper267b3276efc2\Nette\Utils\Strings;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Util\StaticRectorStrings;
use Rector\Set\ValueObject\DowngradeSetList;
use Rector\Set\ValueObject\SetList;
use ReflectionClass;
use Symplify\SetConfigResolver\Exception\SetNotFoundException;
use Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use Symplify\SetConfigResolver\ValueObject\Set;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RectorSetProvider extends \Symplify\SetConfigResolver\Provider\AbstractSetProvider
{
    /**
     * @var string
     * @see https://regex101.com/r/8gO8w6/1
     */
    private const DASH_NUMBER_REGEX = '#\\-(\\d+)#';
    /**
     * @var string[]
     */
    private const SET_LIST_CLASSES = [\Rector\Set\ValueObject\SetList::class, \Rector\Set\ValueObject\DowngradeSetList::class];
    /**
     * @var Set[]
     */
    private $sets = [];
    public function __construct()
    {
        foreach (self::SET_LIST_CLASSES as $setListClass) {
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
    public function provideByName(string $desiredSetName) : ?\Symplify\SetConfigResolver\ValueObject\Set
    {
        $foundSet = parent::provideByName($desiredSetName);
        if ($foundSet instanceof \Symplify\SetConfigResolver\ValueObject\Set) {
            return $foundSet;
        }
        // sencond approach by set path
        foreach ($this->sets as $set) {
            if (!\file_exists($desiredSetName)) {
                continue;
            }
            $desiredSetFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($desiredSetName);
            $setFileInfo = $set->getSetFileInfo();
            if ($setFileInfo->getRealPath() !== $desiredSetFileInfo->getRealPath()) {
                continue;
            }
            return $set;
        }
        $message = \sprintf('Set "%s" was not found', $desiredSetName);
        throw new \Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $desiredSetName, $this->provideSetNames());
    }
    private function hydrateSetsFromConstants(\ReflectionClass $setListReflectionClass) : void
    {
        foreach ($setListReflectionClass->getConstants() as $name => $setPath) {
            if (!\file_exists($setPath)) {
                $message = \sprintf('Set path "%s" was not found', $name);
                throw new \Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $setName = \Rector\Core\Util\StaticRectorStrings::constantToDashes($name);
            // remove `-` before numbers
            $setName = \_PhpScoper267b3276efc2\Nette\Utils\Strings::replace($setName, self::DASH_NUMBER_REGEX, '$1');
            $this->sets[] = new \Symplify\SetConfigResolver\ValueObject\Set($setName, new \Symplify\SmartFileSystem\SmartFileInfo($setPath));
        }
    }
}
