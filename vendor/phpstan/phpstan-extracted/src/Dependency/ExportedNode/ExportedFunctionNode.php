<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use _PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode;
class ExportedFunctionNode implements \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    /** @var string */
    private $name;
    /** @var ExportedPhpDocNode|null */
    private $phpDoc;
    /** @var bool */
    private $byRef;
    /** @var string|null */
    private $returnType;
    /** @var ExportedParameterNode[] */
    private $parameters;
    /**
     * @param string $name
     * @param ExportedPhpDocNode|null $phpDoc
     * @param bool $byRef
     * @param string|null $returnType
     * @param ExportedParameterNode[] $parameters
     */
    public function __construct(string $name, ?\_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode\ExportedPhpDocNode $phpDoc, bool $byRef, ?string $returnType, array $parameters)
    {
        $this->name = $name;
        $this->phpDoc = $phpDoc;
        $this->byRef = $byRef;
        $this->returnType = $returnType;
        $this->parameters = $parameters;
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode $node) : bool
    {
        if (!$node instanceof self) {
            return \false;
        }
        if (\count($this->parameters) !== \count($node->parameters)) {
            return \false;
        }
        foreach ($this->parameters as $i => $ourParameter) {
            $theirParameter = $node->parameters[$i];
            if (!$ourParameter->equals($theirParameter)) {
                return \false;
            }
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
        return $this->name === $node->name && $this->byRef === $node->byRef && $this->returnType === $node->returnType;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode
    {
        return new self($properties['name'], $properties['phpDoc'], $properties['byRef'], $properties['returnType'], $properties['parameters']);
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['name' => $this->name, 'phpDoc' => $this->phpDoc, 'byRef' => $this->byRef, 'returnType' => $this->returnType, 'parameters' => $this->parameters]];
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode
    {
        return new self($data['name'], $data['phpDoc'] !== null ? \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::decode($data['phpDoc']['data']) : null, $data['byRef'], $data['returnType'], \array_map(static function (array $parameterData) : ExportedParameterNode {
            if ($parameterData['type'] !== \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode\ExportedParameterNode::class) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            return \_PhpScoperb75b35f52b74\PHPStan\Dependency\ExportedNode\ExportedParameterNode::decode($parameterData['data']);
        }, $data['parameters']));
    }
}
