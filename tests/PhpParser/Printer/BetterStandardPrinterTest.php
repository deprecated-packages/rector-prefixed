<?php

declare (strict_types=1);
namespace Rector\Core\Tests\PhpParser\Printer;

use Iterator;
use PhpParser\Comment;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class BetterStandardPrinterTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->betterStandardPrinter = self::$container->get(\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
    }
    public function testAddingCommentOnSomeNodesFail() : void
    {
        $methodCall = new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable('this'), 'run');
        // cannot be on MethodCall, must be Expression
        $methodCallExpression = new \PhpParser\Node\Stmt\Expression($methodCall);
        $methodCallExpression->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \PhpParser\Comment('// todo: fix')]);
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('run');
        $methodBuilder->addStmt($methodCallExpression);
        $classMethod = $methodBuilder->getNode();
        $printed = $this->betterStandardPrinter->print($classMethod) . \PHP_EOL;
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected_code_with_non_stmt_placed_nested_comment.php.inc', $printed);
    }
    public function testStringWithAddedComment() : void
    {
        $string = new \PhpParser\Node\Scalar\String_('hey');
        $string->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \PhpParser\Comment('// todo: fix')]);
        $printed = $this->betterStandardPrinter->print($string) . \PHP_EOL;
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected_code_with_comment.php.inc', $printed);
    }
    /**
     * @dataProvider provideDataForDoubleSlashEscaping()
     */
    public function testDoubleSlashEscaping(string $content, string $expectedOutput) : void
    {
        $printed = $this->betterStandardPrinter->print(new \PhpParser\Node\Scalar\String_($content));
        $this->assertSame($expectedOutput, $printed);
    }
    public function provideDataForDoubleSlashEscaping() : \Iterator
    {
        (yield ['_PhpScoperbd5d0c5f7638\\Vendor\\Name', "'Vendor\\Name'"]);
        (yield ['Vendor\\', "'Vendor\\\\'"]);
        (yield ["Vendor'Name", "'Vendor\\'Name'"]);
    }
    public function testYield() : void
    {
        $printed = $this->betterStandardPrinter->print(new \PhpParser\Node\Expr\Yield_(new \PhpParser\Node\Scalar\String_('value')));
        $this->assertSame("yield 'value'", $printed);
        $printed = $this->betterStandardPrinter->print(new \PhpParser\Node\Expr\Yield_());
        $this->assertSame('yield', $printed);
    }
}
