<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use _PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode;
class ExportedInterfaceNode implements \_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    /** @var string */
    private $name;
    /** @var ExportedPhpDocNode|null */
    private $phpDoc;
    /** @var string[] */
    private $extends;
    /**
     * @param string $name
     * @param ExportedPhpDocNode|null $phpDoc
     * @param string[] $extends
     */
    public function __construct(string $name, ?\_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode\ExportedPhpDocNode $phpDoc, array $extends)
    {
        $this->name = $name;
        $this->phpDoc = $phpDoc;
        $this->extends = $extends;
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode $node) : bool
    {
        if (!$node instanceof self) {
            return \false;
        }
        if ($this->phpDoc === null) {
            if ($node->phpDoc !== null) {
                return \false;
            }
        } elseif ($node->phpDoc !== null) {
            if (!$this->phpDoc->equals($node->phpDoc)) {
                return \false;
            }
        } else {
            return \false;
        }
        return $this->name === $node->name && $this->extends === $node->extends;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode
    {
        return new self($properties['name'], $properties['phpDoc'], $properties['extends']);
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['name' => $this->name, 'phpDoc' => $this->phpDoc, 'extends' => $this->extends]];
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode
    {
        return new self($data['name'], $data['phpDoc'] !== null ? \_PhpScoper0a2ac50786fa\PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::decode($data['phpDoc']['data']) : null, $data['extends']);
    }
}
