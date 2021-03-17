<?php

declare (strict_types=1);
namespace Rector\Renaming\ValueObject;

use PHPStan\Type\ObjectType;
use Rector\Renaming\Contract\RenameClassConstFetchInterface;
final class RenameClassAndConstFetch implements \Rector\Renaming\Contract\RenameClassConstFetchInterface
{
    /**
     * @var string
     */
    private $oldClass;
    /**
     * @var string
     */
    private $oldConstant;
    /**
     * @var string
     */
    private $newConstant;
    /**
     * @var string
     */
    private $newClass;
    /**
     * @param string $oldClass
     * @param string $oldConstant
     * @param string $newClass
     * @param string $newConstant
     */
    public function __construct($oldClass, $oldConstant, $newClass, $newConstant)
    {
        $this->oldClass = $oldClass;
        $this->oldConstant = $oldConstant;
        $this->newConstant = $newConstant;
        $this->newClass = $newClass;
    }
    public function getOldObjectType() : \PHPStan\Type\ObjectType
    {
        return new \PHPStan\Type\ObjectType($this->oldClass);
    }
    public function getOldConstant() : string
    {
        return $this->oldConstant;
    }
    public function getNewConstant() : string
    {
        return $this->newConstant;
    }
    public function getNewClass() : string
    {
        return $this->newClass;
    }
}
