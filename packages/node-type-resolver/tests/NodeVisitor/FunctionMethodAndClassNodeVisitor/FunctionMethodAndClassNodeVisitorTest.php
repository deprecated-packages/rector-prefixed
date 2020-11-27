<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\NodeVisitor\FunctionMethodAndClassNodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeVisitor\FunctionMethodAndClassNodeVisitor;
use Rector\Testing\PHPUnit\AbstractNodeVisitorTestCase;
final class FunctionMethodAndClassNodeVisitorTest extends \Rector\Testing\PHPUnit\AbstractNodeVisitorTestCase
{
    /**
     * @var FunctionMethodAndClassNodeVisitor
     */
    private $functionMethodAndClassNodeVisitor;
    protected function setUp() : void
    {
        parent::setUp();
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->functionMethodAndClassNodeVisitor = self::$container->get(\Rector\NodeTypeResolver\NodeVisitor\FunctionMethodAndClassNodeVisitor::class);
    }
    public function testMethodName() : void
    {
        $parsedAttributes = $this->parseFileToAttribute(__DIR__ . '/Fixture/simple.php.inc', \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        $classAttributes = $parsedAttributes[3];
        $this->assertSame(null, $classAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME]);
        $classMethodAttributes = $parsedAttributes[4];
        $this->assertSame('bar', $classMethodAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME]);
        $methodNameAttributes = $parsedAttributes[5];
        $this->assertSame('bar', $methodNameAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME]);
    }
    public function testClassName() : void
    {
        $parsedAttributes = $this->parseFileToAttribute(__DIR__ . '/Fixture/simple.php.inc', \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $classMethodAttributes = $parsedAttributes[3];
        $this->assertSame('Rector\\NodeTypeResolver\\Tests\\NodeVisitor\\FunctionMethodAndClassNodeVisitorTest\\Fixture\\Foo', $classMethodAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME]);
        $classAttributes = $parsedAttributes[4];
        $this->assertSame('Rector\\NodeTypeResolver\\Tests\\NodeVisitor\\FunctionMethodAndClassNodeVisitorTest\\Fixture\\Foo', $classAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME]);
    }
    public function testClassNode() : void
    {
        $parsedAttributes = $this->parseFileToAttribute(__DIR__ . '/Fixture/simple.php.inc', \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $classMethodAttributes = $parsedAttributes[3];
        $this->assertInstanceOf(\PhpParser\Node\Stmt\Class_::class, $classMethodAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE]);
    }
    public function testAnonymousClassName() : void
    {
        $parsedAttributes = $this->parseFileToAttribute(__DIR__ . '/Fixture/anonymous_class.php.inc', \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $funcCallAttributes = $parsedAttributes[10];
        $this->assertSame('Rector\\NodeTypeResolver\\Tests\\NodeVisitor\\FunctionMethodAndClassNodeVisitorTest\\Fixture\\AnonymousClass', $funcCallAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME]);
        // method in the anonymous class has no class name
        $anoymousClassMethodAttributes = $parsedAttributes[8];
        $this->assertNull($anoymousClassMethodAttributes[\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME]);
    }
    /**
     * @param Node[] $nodes
     */
    public function traverseNodes(array $nodes) : void
    {
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \PhpParser\NodeVisitor\NameResolver());
        $nodeTraverser->addVisitor($this->functionMethodAndClassNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
}
