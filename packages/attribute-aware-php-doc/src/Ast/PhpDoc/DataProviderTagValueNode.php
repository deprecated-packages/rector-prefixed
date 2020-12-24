<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class DataProviderTagValueNode implements \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    /**
     * @var string
     */
    private $method;
    public function __construct(string $method)
    {
        $this->method = $method;
    }
    public function __toString() : string
    {
        return $this->method;
    }
    public function getMethod() : string
    {
        return $this->method;
    }
    public function getMethodName() : string
    {
        return \trim($this->method, '()');
    }
    public function changeMethod(string $method) : void
    {
        $this->method = $method;
    }
}
