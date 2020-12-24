<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\PhpDoc;

class TypeNodeResolverExtensionRegistry
{
    /** @var TypeNodeResolverExtension[] */
    private $extensions;
    /**
     * @param TypeNodeResolverExtension[] $extensions
     */
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver, array $extensions)
    {
        foreach ($extensions as $extension) {
            if (!$extension instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDoc\TypeNodeResolverAwareExtension) {
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
