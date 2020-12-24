<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign, \_PhpScopere8e811afab72\PhpParser\Node\Param $param)
    {
        $this->property = $property;
        $this->assign = $assign;
        $this->param = $param;
    }
    public function getProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        return $this->property;
    }
    public function getAssign() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        return $this->assign;
    }
    public function getParam() : \_PhpScopere8e811afab72\PhpParser\Node\Param
    {
        return $this->param;
    }
}
