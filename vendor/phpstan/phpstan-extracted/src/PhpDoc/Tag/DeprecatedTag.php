<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\PhpDoc\Tag;

class DeprecatedTag
{
    /** @var string|null */
    private $message;
    public function __construct(?string $message)
    {
        $this->message = $message;
    }
    public function getMessage() : ?string
    {
        return $this->message;
    }
    /**
     * @param mixed[] $properties
     * @return DeprecatedTag
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['message']);
    }
}
