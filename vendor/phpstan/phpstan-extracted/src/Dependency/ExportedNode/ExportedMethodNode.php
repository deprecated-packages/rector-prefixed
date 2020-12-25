<?php

declare (strict_types=1);
namespace PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use PHPStan\Dependency\ExportedNode;
class ExportedMethodNode implements \PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    /** @var string */
    private $name;
    /** @var ExportedPhpDocNode|null */
    private $phpDoc;
    /** @var bool */
    private $byRef;
    /** @var bool */
    private $public;
    /** @var bool */
    private $private;
    /** @var bool */
    private $abstract;
    /** @var bool */
    private $final;
    /** @var bool */
    private $static;
    /** @var string|null */
    private $returnType;
    /** @var ExportedParameterNode[] */
    private $parameters;
    /**
     * @param string $name
     * @param ExportedPhpDocNode|null $phpDoc
     * @param bool $byRef
     * @param bool $public
     * @param bool $private
     * @param bool $abstract
     * @param bool $final
     * @param bool $static
     * @param string|null $returnType
     * @param ExportedParameterNode[] $parameters
     */
    public function __construct(string $name, ?\PHPStan\Dependency\ExportedNode\ExportedPhpDocNode $phpDoc, bool $byRef, bool $public, bool $private, bool $abstract, bool $final, bool $static, ?string $returnType, array $parameters)
    {
        $this->name = $name;
        $this->phpDoc = $phpDoc;
        $this->byRef = $byRef;
        $this->public = $public;
        $this->private = $private;
        $this->abstract = $abstract;
        $this->final = $final;
        $this->static = $static;
        $this->returnType = $returnType;
        $this->parameters = $parameters;
    }
    public function equals(\PHPStan\Dependency\ExportedNode $node) : bool
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
        return $this->name === $node->name && $this->byRef === $node->byRef && $this->public === $node->public && $this->private === $node->private && $this->abstract === $node->abstract && $this->final === $node->final && $this->static === $node->static && $this->returnType === $node->returnType;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \PHPStan\Dependency\ExportedNode
    {
        return new self($properties['name'], $properties['phpDoc'], $properties['byRef'], $properties['public'], $properties['private'], $properties['abstract'], $properties['final'], $properties['static'], $properties['returnType'], $properties['parameters']);
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['name' => $this->name, 'phpDoc' => $this->phpDoc, 'byRef' => $this->byRef, 'public' => $this->public, 'private' => $this->private, 'abstract' => $this->abstract, 'final' => $this->final, 'static' => $this->static, 'returnType' => $this->returnType, 'parameters' => $this->parameters]];
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \PHPStan\Dependency\ExportedNode
    {
        return new self($data['name'], $data['phpDoc'] !== null ? \PHPStan\Dependency\ExportedNode\ExportedPhpDocNode::decode($data['phpDoc']['data']) : null, $data['byRef'], $data['public'], $data['private'], $data['abstract'], $data['final'], $data['static'], $data['returnType'], \array_map(static function (array $parameterData) : ExportedParameterNode {
            if ($parameterData['type'] !== \PHPStan\Dependency\ExportedNode\ExportedParameterNode::class) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            return \PHPStan\Dependency\ExportedNode\ExportedParameterNode::decode($parameterData['data']);
        }, $data['parameters']));
    }
}
