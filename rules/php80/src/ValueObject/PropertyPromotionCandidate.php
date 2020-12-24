<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param)
    {
        $this->property = $property;
        $this->assign = $assign;
        $this->param = $param;
    }
    public function getProperty() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property
    {
        return $this->property;
    }
    public function getAssign() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign
    {
        return $this->assign;
    }
    public function getParam() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        return $this->param;
    }
}
