<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BrokerAwareExtension;
class OperatorTypeSpecifyingExtensionRegistry
{
    /** @var OperatorTypeSpecifyingExtension[] */
    private $extensions;
    /**
     * @param \PHPStan\Type\OperatorTypeSpecifyingExtension[] $extensions
     */
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker, array $extensions)
    {
        foreach ($extensions as $extension) {
            if (!$extension instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\BrokerAwareExtension) {
                continue;
            }
            $extension->setBroker($broker);
        }
        $this->extensions = $extensions;
    }
    /**
     * @return OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions(string $operator, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $leftType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $rightType) : array
    {
        return \array_values(\array_filter($this->extensions, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtension $extension) use($operator, $leftType, $rightType) : bool {
            return $extension->isOperatorSupported($operator, $leftType, $rightType);
        }));
    }
}
