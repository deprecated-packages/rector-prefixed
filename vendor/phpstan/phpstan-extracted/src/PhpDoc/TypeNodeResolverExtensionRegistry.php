<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

class TypeNodeResolverExtensionRegistry
{
    /** @var TypeNodeResolverExtension[] */
    private $extensions;
    /**
     * @param TypeNodeResolverExtension[] $extensions
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver, array $extensions)
    {
        foreach ($extensions as $extension) {
            if (!$extension instanceof \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverAwareExtension) {
                continue;
            }
            $extension->setTypeNodeResolver($typeNodeResolver);
        }
        $this->extensions = $extensions;
    }
    /**
     * @return TypeNodeResolverExtension[]
     */
    public function getExtensions() : array
    {
        return $this->extensions;
    }
}
