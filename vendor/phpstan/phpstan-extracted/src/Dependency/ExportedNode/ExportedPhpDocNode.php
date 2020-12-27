<?php

declare (strict_types=1);
namespace PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use PHPStan\Dependency\ExportedNode;
class ExportedPhpDocNode implements \PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    /** @var string */
    private $phpDocString;
    /** @var string|null */
    private $namespace;
    /** @var array<string, string> alias(string) => fullName(string) */
    private $uses;
    /**
     * @param string $phpDocString
     * @param string|null $namespace
     * @param array<string, string> $uses
     */
    public function __construct(string $phpDocString, ?string $namespace, array $uses)
    {
        $this->phpDocString = $phpDocString;
        $this->namespace = $namespace;
        $this->uses = $uses;
    }
    public function equals(\PHPStan\Dependency\ExportedNode $node) : bool
    {
        if (!$node instanceof self) {
            return \false;
        }
        return $this->phpDocString === $node->phpDocString && $this->namespace === $node->namespace && $this->uses === $node->uses;
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['phpDocString' => $this->phpDocString, 'namespace' => $this->namespace, 'uses' => $this->uses]];
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \PHPStan\Dependency\ExportedNode
    {
        return new self($properties['phpDocString'], $properties['namespace'], $properties['uses']);
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \PHPStan\Dependency\ExportedNode
    {
        return new self($data['phpDocString'], $data['namespace'], $data['uses']);
    }
}
