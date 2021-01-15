<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeAnalyzer;

use PhpParser\Node;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class TestsNodeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isInTestClass(\PhpParser\Node $node) : bool
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return $this->nodeTypeResolver->isObjectTypes($classLike, ['PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase']);
    }
}
