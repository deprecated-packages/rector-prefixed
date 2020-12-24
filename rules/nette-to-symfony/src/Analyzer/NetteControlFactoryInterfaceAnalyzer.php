<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Analyzer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class NetteControlFactoryInterfaceAnalyzer
{
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer)
    {
        $this->returnTypeInferer = $returnTypeInferer;
    }
    /**
     * @see https://doc.nette.org/en/3.0/components#toc-components-with-dependencies
     */
    public function isComponentFactoryInterface(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_ $interface) : bool
    {
        foreach ($interface->getMethods() as $classMethod) {
            $returnType = $this->returnTypeInferer->inferFunctionLike($classMethod);
            if (!$returnType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $className = $this->resolveClassName($returnType);
            if (\is_a($className, '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\UI\\Control', \true)) {
                return \true;
            }
            if (\is_a($className, '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\UI\\Form', \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function resolveClassName(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
