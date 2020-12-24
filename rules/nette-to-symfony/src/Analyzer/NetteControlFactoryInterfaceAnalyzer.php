<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Analyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class NetteControlFactoryInterfaceAnalyzer
{
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer)
    {
        $this->returnTypeInferer = $returnTypeInferer;
    }
    /**
     * @see https://doc.nette.org/en/3.0/components#toc-components-with-dependencies
     */
    public function isComponentFactoryInterface(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_ $interface) : bool
    {
        foreach ($interface->getMethods() as $classMethod) {
            $returnType = $this->returnTypeInferer->inferFunctionLike($classMethod);
            if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $className = $this->resolveClassName($returnType);
            if (\is_a($className, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Control', \true)) {
                return \true;
            }
            if (\is_a($className, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Form', \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function resolveClassName(\_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
