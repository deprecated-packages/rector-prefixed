<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\ValueObject;

final class PropertyAssignToMethodCall
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $oldPropertyName;
    /**
     * @var string
     */
    private $newMethodName;
    public function __construct(string $class, string $oldPropertyName, string $newMethodName)
    {
        $this->class = $class;
        $this->oldPropertyName = $oldPropertyName;
        $this->newMethodName = $newMethodName;
    }
    public function getClass() : string
    {
        return $this->class;
    }
    public function getOldPropertyName() : string
    {
        return $this->oldPropertyName;
    }
    public function getNewMethodName() : string
    {
        return $this->newMethodName;
    }
}
