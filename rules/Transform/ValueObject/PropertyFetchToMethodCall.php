<?php

declare(strict_types=1);

namespace Rector\Transform\ValueObject;

use PHPStan\Type\ObjectType;

final class PropertyFetchToMethodCall
{
    /**
     * @var string
     */
    private $oldType;

    /**
     * @var string
     */
    private $oldProperty;

    /**
     * @var string
     */
    private $newGetMethod;

    /**
     * @var mixed[]
     */
    private $newGetArguments = [];

    /**
     * @var string|null
     */
    private $newSetMethod;

    /**
     * @param mixed[] $newGetArguments
     * @param string|null $newSetMethod
     */
    public function __construct(
        string $oldType,
        string $oldProperty,
        string $newGetMethod,
        $newSetMethod = null,
        array $newGetArguments = []
    ) {
        $this->oldType = $oldType;
        $this->oldProperty = $oldProperty;
        $this->newGetMethod = $newGetMethod;
        $this->newSetMethod = $newSetMethod;
        $this->newGetArguments = $newGetArguments;
    }

    public function getOldObjectType(): ObjectType
    {
        return new ObjectType($this->oldType);
    }

    public function getOldProperty(): string
    {
        return $this->oldProperty;
    }

    public function getNewGetMethod(): string
    {
        return $this->newGetMethod;
    }

    /**
     * @return string|null
     */
    public function getNewSetMethod()
    {
        return $this->newSetMethod;
    }

    /**
     * @return mixed[]
     */
    public function getNewGetArguments(): array
    {
        return $this->newGetArguments;
    }
}
