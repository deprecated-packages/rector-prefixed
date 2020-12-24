<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/doctrine/orm/blob/2.7/UPGRADE.md#query-querybuilder-and-nativequery-parameters-bc-break
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\MethodCall\ChangeSetParametersArrayToArrayCollectionRector\ChangeSetParametersArrayToArrayCollectionRectorTest
 */
final class ChangeSetParametersArrayToArrayCollectionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
        $node->args = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($new)];
        return $node;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array to ArrayCollection in setParameters method of query builder', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    private function shouldSkipMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $classLike = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        //one of the cases when we are in the repo and it's extended from EntityRepository
        if (!$this->isObjectType($classLike, '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\EntityRepository')) {
            return \true;
        }
        if (!$this->isObjectType($methodCall->var, '_PhpScoper0a6b37af0871\\Doctrine\\ORM\\EntityRepository')) {
            return \true;
        }
        return !$this->isName($methodCall->name, 'setParameters');
    }
    private function getNewArrayCollectionFromSetParametersArgument(\_PhpScoper0a6b37af0871\PhpParser\Node\Arg $arg) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_
    {
        /** @var Array_ $arrayExpression */
        $arrayExpression = $arg->value;
        /** @var ArrayItem[] $firstArgumentArrayItems */
        $firstArgumentArrayItems = $arrayExpression->items;
        $arrayCollectionArrayArguments = [];
        foreach ($firstArgumentArrayItems as $firstArgumentArrayItem) {
            if (!$firstArgumentArrayItem->key instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_ || !$firstArgumentArrayItem->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            $queryParameter = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Query\\Parameter'));
            $queryParameter->args = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($firstArgumentArrayItem->key), new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($firstArgumentArrayItem->value)];
            $arrayCollectionArrayArguments[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem($queryParameter);
        }
        $arrayCollection = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Doctrine\\Common\\Collections\\ArrayCollection'));
        $arrayCollection->args = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_($arrayCollectionArrayArguments))];
        return $arrayCollection;
    }
}
