<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param)
    {
        $this->property = $property;
        $this->assign = $assign;
        $this->param = $param;
    }
    public function getProperty() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        return $this->property;
    }
    public function getAssign() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        return $this->assign;
    }
    public function getParam() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        return $this->param;
    }
}
