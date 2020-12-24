<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\BrokerAwareExtension;
class OperatorTypeSpecifyingExtensionRegistry
{
    /** @var OperatorTypeSpecifyingExtension[] */
    private $extensions;
    /**
     * @param \PHPStan\Type\OperatorTypeSpecifyingExtension[] $extensions
     */
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Broker\Broker $broker, array $extensions)
    {
        foreach ($extensions as $extension) {
            if (!$extension instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\BrokerAwareExtension) {
                continue;
            }
            $extension->setBroker($broker);
        }
        $this->extensions = $extensions;
    }
    /**
     * @return OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions(string $operator, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $leftType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $rightType) : array
    {
        return \array_values(\array_filter($this->extensions, static function (\_PhpScoper0a6b37af0871\PHPStan\Type\OperatorTypeSpecifyingExtension $extension) use($operator, $leftType, $rightType) : bool {
            return $extension->isOperatorSupported($operator, $leftType, $rightType);
        }));
    }
}
