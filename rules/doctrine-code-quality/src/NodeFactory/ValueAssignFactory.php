<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
final class ValueAssignFactory
{
    public function createDefaultDateTimeAssign(string $propertyName) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch($propertyName);
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, $this->createNewDateTime());
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    public function createDefaultDateTimeWithValueAssign(string $propertyName, \_PhpScopere8e811afab72\PhpParser\Node\Expr $defaultExpr) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch($propertyName);
        $newDateTime = $this->createNewDateTime();
        $this->addDateTimeArgumentIfNotDefault($defaultExpr, $newDateTime);
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, $newDateTime);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createPropertyFetch(string $propertyName) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $propertyName);
    }
    private function createNewDateTime() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('DateTime'));
    }
    private function addDateTimeArgumentIfNotDefault(\_PhpScopere8e811afab72\PhpParser\Node\Expr $defaultExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $dateTimeNew) : void
    {
        if ($defaultExpr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ && ($defaultExpr->value === 'now' || $defaultExpr->value === 'now()')) {
            return;
        }
        $dateTimeNew->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($defaultExpr);
    }
}
