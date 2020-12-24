<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Set;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\Set\ValueObject\DowngradeSetList;
use _PhpScopere8e811afab72\Rector\Set\ValueObject\SetList;
use ReflectionClass;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Provider\AbstractSetProvider;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RectorSetProvider extends \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Provider\AbstractSetProvider
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
        foreach ([\_PhpScopere8e811afab72\Rector\Set\ValueObject\SetList::class, \_PhpScopere8e811afab72\Rector\Set\ValueObject\DowngradeSetList::class] as $setListClass) {
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
    public function provideByName(string $desiredSetName) : ?\_PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set
    {
        $foundSet = parent::provideByName($desiredSetName);
        if ($foundSet instanceof \_PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set) {
            return $foundSet;
        }
        // sencond approach by set path
        foreach ($this->sets as $set) {
            if (!\file_exists($desiredSetName)) {
                continue;
            }
            $desiredSetFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($desiredSetName);
            $setFileInfo = $set->getSetFileInfo();
            if ($setFileInfo->getRealPath() !== $desiredSetFileInfo->getRealPath()) {
                continue;
            }
            return $set;
        }
        $message = \sprintf('Set "%s" was not found', $desiredSetName);
        throw new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $desiredSetName, $this->provideSetNames());
    }
    private function hydrateSetsFromConstants(\ReflectionClass $setListReflectionClass) : void
    {
        foreach ((array) $setListReflectionClass->getConstants() as $name => $setPath) {
            if (!\file_exists($setPath)) {
                $message = \sprintf('Set path "%s" was not found', $name);
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $setName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::constantToDashes($name);
            // remove `-` before numbers
            $setName = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($setName, self::DASH_NUMBER_REGEX, '$1');
            $this->sets[] = new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\ValueObject\Set($setName, new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($setPath));
        }
    }
}
