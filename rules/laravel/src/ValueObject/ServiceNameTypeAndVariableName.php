<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Laravel\ValueObject;

final class ServiceNameTypeAndVariableName
{
    /**
     * @var string
     */
    private $serviceName;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $variableName;
    public function __construct(string $serviceName, string $type, string $variableName)
    {
        $this->serviceName = $serviceName;
        $this->type = $type;
        $this->variableName = $variableName;
    }
    public function getServiceName() : string
    {
        return $this->serviceName;
    }
    public function getType() : string
    {
        return $this->type;
    }
    public function getVariableName() : string
    {
        return $this->variableName;
    }
}
