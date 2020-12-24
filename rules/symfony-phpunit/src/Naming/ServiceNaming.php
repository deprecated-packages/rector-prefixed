<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SymfonyPHPUnit\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
final class ServiceNaming
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function resolvePropertyNameFromServiceType(string $serviceType) : string
    {
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($serviceType, '\\')) {
            return $this->propertyNaming->underscoreToName($serviceType);
        }
        return $this->propertyNaming->fqnToVariableName(new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($serviceType));
    }
}
