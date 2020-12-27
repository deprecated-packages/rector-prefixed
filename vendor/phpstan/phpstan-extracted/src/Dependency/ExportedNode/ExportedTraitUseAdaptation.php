<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use RectorPrefix20201227\PHPStan\Dependency\ExportedNode;
class ExportedTraitUseAdaptation implements \RectorPrefix20201227\PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    /** @var string|null */
    private $traitName;
    /** @var string */
    private $method;
    /** @var int|null */
    private $newModifier;
    /** @var string|null */
    private $newName;
    /** @var string[]|null */
    private $insteadOfs;
    /**
     * @param string|null $traitName
     * @param string $method
     * @param int|null $newModifier
     * @param string|null $newName
     * @param string[]|null $insteadOfs
     */
    private function __construct(?string $traitName, string $method, ?int $newModifier, ?string $newName, ?array $insteadOfs)
    {
        $this->traitName = $traitName;
        $this->method = $method;
        $this->newModifier = $newModifier;
        $this->newName = $newName;
        $this->insteadOfs = $insteadOfs;
    }
    public static function createAlias(?string $traitName, string $method, ?int $newModifier, ?string $newName) : self
    {
        return new self($traitName, $method, $newModifier, $newName, null);
    }
    /**
     * @param string|null $traitName
     * @param string $method
     * @param string[] $insteadOfs
     * @return self
     */
    public static function createPrecedence(?string $traitName, string $method, array $insteadOfs) : self
    {
        return new self($traitName, $method, null, null, $insteadOfs);
    }
    public function equals(\RectorPrefix20201227\PHPStan\Dependency\ExportedNode $node) : bool
    {
        if (!$node instanceof self) {
            return \false;
        }
        return $this->traitName === $node->traitName && $this->method === $node->method && $this->newModifier === $node->newModifier && $this->newName === $node->newName && $this->insteadOfs === $node->insteadOfs;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \RectorPrefix20201227\PHPStan\Dependency\ExportedNode
    {
        return new self($properties['traitName'], $properties['method'], $properties['newModifier'], $properties['newName'], $properties['insteadOfs']);
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \RectorPrefix20201227\PHPStan\Dependency\ExportedNode
    {
        return new self($data['traitName'], $data['method'], $data['newModifier'], $data['newName'], $data['insteadOfs']);
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['traitName' => $this->traitName, 'method' => $this->method, 'newModifier' => $this->newModifier, 'newName' => $this->newName, 'insteadOfs' => $this->insteadOfs]];
    }
}
