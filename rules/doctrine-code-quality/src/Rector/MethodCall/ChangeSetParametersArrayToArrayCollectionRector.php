<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/doctrine/orm/blob/2.7/UPGRADE.md#query-querybuilder-and-nativequery-parameters-bc-break
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\MethodCall\ChangeSetParametersArrayToArrayCollectionRector\ChangeSetParametersArrayToArrayCollectionRectorTest
 */
final class ChangeSetParametersArrayToArrayCollectionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkipMethodCall($node)) {
            return null;
        }
        $methodArguments = $node->args;
        if (\count($methodArguments) !== 1) {
            return null;
        }
        $firstArgument = $methodArguments[0];
        if (!$this->isArrayType($firstArgument->value)) {
            return null;
        }
        unset($node->args);
        $new = $this->getNewArrayCollectionFromSetParametersArgument($firstArgument);
        $node->args = [new \PhpParser\Node\Arg($new)];
        return $node;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array to ArrayCollection in setParameters method of query builder', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\EntityRepository;

class SomeRepository extends EntityRepository
{
    public function getSomething()
    {
        return $this
            ->createQueryBuilder('sm')
            ->select('sm')
            ->where('sm.foo = :bar')
            ->setParameters([
                'bar' => 'baz'
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Parameter;

class SomeRepository extends EntityRepository
{
    public function getSomething()
    {
        return $this
            ->createQueryBuilder('sm')
            ->select('sm')
            ->where('sm.foo = :bar')
            ->setParameters(new ArrayCollection([
                new  Parameter('bar', 'baz'),
            ]))
            ->getQuery()
            ->getResult()
        ;
    }
}
CODE_SAMPLE
)]);
    }
    private function shouldSkipMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $classLike = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        //one of the cases when we are in the repo and it's extended from EntityRepository
        if (!$this->isObjectType($classLike, '_PhpScoper5edc98a7cce2\\Doctrine\\ORM\\EntityRepository')) {
            return \true;
        }
        if (!$this->isObjectType($methodCall->var, '_PhpScoper5edc98a7cce2\\Doctrine\\ORM\\EntityRepository')) {
            return \true;
        }
        return !$this->isName($methodCall->name, 'setParameters');
    }
    private function getNewArrayCollectionFromSetParametersArgument(\PhpParser\Node\Arg $arg) : \PhpParser\Node\Expr\New_
    {
        /** @var Array_ $arrayExpression */
        $arrayExpression = $arg->value;
        /** @var ArrayItem[] $firstArgumentArrayItems */
        $firstArgumentArrayItems = $arrayExpression->items;
        $arrayCollectionArrayArguments = [];
        foreach ($firstArgumentArrayItems as $firstArgumentArrayItem) {
            if (!$firstArgumentArrayItem->key instanceof \PhpParser\Node\Scalar\String_ || !$firstArgumentArrayItem->value instanceof \PhpParser\Node\Scalar\String_) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $queryParameter = new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified('_PhpScoper5edc98a7cce2\\Doctrine\\ORM\\Query\\Parameter'));
            $queryParameter->args = [new \PhpParser\Node\Arg($firstArgumentArrayItem->key), new \PhpParser\Node\Arg($firstArgumentArrayItem->value)];
            $arrayCollectionArrayArguments[] = new \PhpParser\Node\Expr\ArrayItem($queryParameter);
        }
        $arrayCollection = new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified('_PhpScoper5edc98a7cce2\\Doctrine\\Common\\Collections\\ArrayCollection'));
        $arrayCollection->args = [new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Array_($arrayCollectionArrayArguments))];
        return $arrayCollection;
    }
}
