<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Analyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class NetteControlFactoryInterfaceAnalyzer
{
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer)
    {
        $this->returnTypeInferer = $returnTypeInferer;
    }
    /**
     * @see https://doc.nette.org/en/3.0/components#toc-components-with-dependencies
     */
    public function isComponentFactoryInterface(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_ $interface) : bool
    {
        foreach ($interface->getMethods() as $classMethod) {
            $returnType = $this->returnTypeInferer->inferFunctionLike($classMethod);
            if (!$returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $className = $this->resolveClassName($returnType);
            if (\is_a($className, '_PhpScoper0a6b37af0871\\Nette\\Application\\UI\\Control', \true)) {
                return \true;
            }
            if (\is_a($className, '_PhpScoper0a6b37af0871\\Nette\\Application\\UI\\Form', \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function resolveClassName(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
