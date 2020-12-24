<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
final class PropertyPromotionCandidate
{
    /**
     * @var Property
     */
    private $property;
    /**
     * @var Assign
     */
    private $assign;
    /**
     * @var Param
     */
    private $param;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign $assign, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param)
    {
        $this->property = $property;
        $this->assign = $assign;
        $this->param = $param;
    }
    public function getProperty() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        return $this->property;
    }
    public function getAssign() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        return $this->assign;
    }
    public function getParam() : \_PhpScoper0a6b37af0871\PhpParser\Node\Param
    {
        return $this->param;
    }
}
