<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use _PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNode;
class ExportedTraitNode implements \_PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    /** @var string */
    private $traitName;
    public function __construct(string $traitName)
    {
        $this->traitName = $traitName;
    }
    public function equals(\_PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNode $node) : bool
    {
        return \false;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNode
    {
        return new self($properties['traitName']);
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \_PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNode
    {
        return new self($data['traitName']);
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['traitName' => $this->traitName]];
    }
}
