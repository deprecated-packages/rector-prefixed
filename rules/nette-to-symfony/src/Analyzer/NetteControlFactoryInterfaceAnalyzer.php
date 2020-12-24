<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Analyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
final class NetteControlFactoryInterfaceAnalyzer
{
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer)
    {
        $this->returnTypeInferer = $returnTypeInferer;
    }
    /**
     * @see https://doc.nette.org/en/3.0/components#toc-components-with-dependencies
     */
    public function isComponentFactoryInterface(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_ $interface) : bool
    {
        foreach ($interface->getMethods() as $classMethod) {
            $returnType = $this->returnTypeInferer->inferFunctionLike($classMethod);
            if (!$returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $className = $this->resolveClassName($returnType);
            if (\is_a($className, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Control', \true)) {
                return \true;
            }
            if (\is_a($className, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Form', \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function resolveClassName(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
