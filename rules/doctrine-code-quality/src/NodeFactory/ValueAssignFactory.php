<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
final class ValueAssignFactory
{
    public function createDefaultDateTimeAssign(string $propertyName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch($propertyName);
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, $this->createNewDateTime());
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
    }
    public function createDefaultDateTimeWithValueAssign(string $propertyName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $defaultExpr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch($propertyName);
        $newDateTime = $this->createNewDateTime();
        $this->addDateTimeArgumentIfNotDefault($defaultExpr, $newDateTime);
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, $newDateTime);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createPropertyFetch(string $propertyName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
    }
    private function createNewDateTime() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('DateTime'));
    }
    private function addDateTimeArgumentIfNotDefault(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $defaultExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ $dateTimeNew) : void
    {
        if ($defaultExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ && ($defaultExpr->value === 'now' || $defaultExpr->value === 'now()')) {
            return;
        }
        $dateTimeNew->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($defaultExpr);
    }
}
