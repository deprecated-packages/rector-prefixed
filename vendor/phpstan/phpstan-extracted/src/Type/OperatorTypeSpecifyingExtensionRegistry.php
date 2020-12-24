<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Reflection\BrokerAwareExtension;
class OperatorTypeSpecifyingExtensionRegistry
{
    /** @var OperatorTypeSpecifyingExtension[] */
    private $extensions;
    /**
     * @param \PHPStan\Type\OperatorTypeSpecifyingExtension[] $extensions
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $broker, array $extensions)
    {
        foreach ($extensions as $extension) {
            if (!$extension instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\BrokerAwareExtension) {
                continue;
            }
            $extension->setBroker($broker);
        }
        $this->extensions = $extensions;
    }
    /**
     * @return OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions(string $operator, \_PhpScopere8e811afab72\PHPStan\Type\Type $leftType, \_PhpScopere8e811afab72\PHPStan\Type\Type $rightType) : array
    {
        return \array_values(\array_filter($this->extensions, static function (\_PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtension $extension) use($operator, $leftType, $rightType) : bool {
            return $extension->isOperatorSupported($operator, $leftType, $rightType);
        }));
    }
}
