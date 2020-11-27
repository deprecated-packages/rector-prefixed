<?php

declare (strict_types=1);
namespace Rector\Sensio\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeTraverser;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Sensio\NodeFactory\ThisRenderFactory;
use Rector\Sensio\TypeAnalyzer\ArrayUnionResponseTypeAnalyzer;
use Rector\Sensio\TypeDeclaration\ReturnTypeDeclarationUpdater;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony-docs/pull/12387#discussion_r329551967
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/view.html
 * @see https://github.com/sensiolabs/SensioFrameworkExtraBundle/issues/641
 *
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector\TemplateAnnotationToThisRenderRectorTest
 */
final class TemplateAnnotationToThisRenderRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const RESPONSE_CLASS = '_PhpScoper006a73f0e455\\Symfony\\Component\\HttpFoundation\\Response';
    /**
     * @var ReturnTypeDeclarationUpdater
     */
    private $returnTypeDeclarationUpdater;
    /**
     * @var ThisRenderFactory
     */
    private $thisRenderFactory;
    /**
     * @var ArrayUnionResponseTypeAnalyzer
     */
    private $arrayUnionResponseTypeAnalyzer;
    public function __construct(\Rector\Sensio\TypeAnalyzer\ArrayUnionResponseTypeAnalyzer $arrayUnionResponseTypeAnalyzer, \Rector\Sensio\TypeDeclaration\ReturnTypeDeclarationUpdater $returnTypeDeclarationUpdater, \Rector\Sensio\NodeFactory\ThisRenderFactory $thisRenderFactory)
    {
        $this->returnTypeDeclarationUpdater = $returnTypeDeclarationUpdater;
        $this->thisRenderFactory = $thisRenderFactory;
        $this->arrayUnionResponseTypeAnalyzer = $arrayUnionResponseTypeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `@Template` annotation to explicit method call in Controller of FrameworkExtraBundle in Symfony', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
/**
 * @Template()
 */
public function indexAction()
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
public function indexAction()
{
    return $this->render('index.html.twig');
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
            return $this->addAbstractControllerParentClassIfMissing($node);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->replaceTemplateAnnotation($node);
        }
        return null;
    }
    private function addAbstractControllerParentClassIfMissing(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Stmt\Class_
    {
        if ($class->extends !== null) {
            return null;
        }
        if (!$this->classHasTemplateAnnotations($class)) {
            return null;
        }
        $class->extends = new \PhpParser\Node\Name\FullyQualified('_PhpScoper006a73f0e455\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController');
        return $class;
    }
    private function replaceTemplateAnnotation(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node
    {
        if (!$classMethod->isPublic()) {
            return null;
        }
        /** @var SensioTemplateTagValueNode|null $sensioTemplateTagValueNode */
        $sensioTemplateTagValueNode = $this->getPhpDocTagValueNode($classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
        if ($sensioTemplateTagValueNode === null) {
            return null;
        }
        $this->refactorClassMethod($classMethod, $sensioTemplateTagValueNode);
        return $classMethod;
    }
    private function classHasTemplateAnnotations(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            if ($this->hasPhpDocTagValueNode($classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class)) {
                return \true;
            }
        }
        return \false;
    }
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : void
    {
        /** @var Return_[] $returns */
        $returns = $this->findReturnsInCurrentScope((array) $classMethod->stmts);
        $hasThisRenderOrReturnsResponse = $this->hasLastReturnResponse($classMethod);
        foreach ($returns as $return) {
            $this->refactorReturn($return, $classMethod, $sensioTemplateTagValueNode, $hasThisRenderOrReturnsResponse);
        }
        if ($returns === []) {
            $thisRenderMethodCall = $this->thisRenderFactory->create($classMethod, null, $sensioTemplateTagValueNode);
            $this->refactorNoReturn($classMethod, $thisRenderMethodCall);
        }
    }
    /**
     * This skips anonymous functions and functions, as their returns doesn't influence current code
     *
     * @param Node[] $stmts
     * @return Return_[]
     */
    private function findReturnsInCurrentScope(array $stmts) : array
    {
        $returns = [];
        $this->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use(&$returns) : ?int {
            if ($node instanceof \PhpParser\Node\Expr\Closure || $node instanceof \PhpParser\Node\Stmt\Function_) {
                return \PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $returns[] = $node;
            return null;
        });
        return $returns;
    }
    private function hasLastReturnResponse(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Return_|null $lastReturn */
        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $classMethod->stmts, \PhpParser\Node\Stmt\Return_::class);
        if ($lastReturn === null) {
            return \false;
        }
        return $this->isReturnOfObjectType($lastReturn, self::RESPONSE_CLASS);
    }
    private function refactorReturn(\PhpParser\Node\Stmt\Return_ $return, \PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode, bool $hasThisRenderOrReturnsResponse) : void
    {
        // nothing we can do
        if ($return->expr === null) {
            return;
        }
        // create "$this->render('template.file.twig.html', ['key' => 'value']);" method call
        $thisRenderMethodCall = $this->thisRenderFactory->create($classMethod, $return, $sensioTemplateTagValueNode);
        $this->refactorReturnWithValue($return, $hasThisRenderOrReturnsResponse, $thisRenderMethodCall, $classMethod);
    }
    private function refactorNoReturn(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $this->processClassMethodWithoutReturn($classMethod, $thisRenderMethodCall);
        $this->returnTypeDeclarationUpdater->updateClassMethod($classMethod, self::RESPONSE_CLASS);
        $this->removePhpDocTagValueNode($classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
    }
    private function refactorReturnWithValue(\PhpParser\Node\Stmt\Return_ $return, bool $hasThisRenderOrReturnsResponse, \PhpParser\Node\Expr\MethodCall $thisRenderMethodCall, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var Expr $lastReturnExpr */
        $lastReturnExpr = $return->expr;
        $returnStaticType = $this->getStaticType($lastReturnExpr);
        if (!$return->expr instanceof \PhpParser\Node\Expr\MethodCall) {
            if (!$hasThisRenderOrReturnsResponse || $returnStaticType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
                $return->expr = $thisRenderMethodCall;
            }
        } elseif ($returnStaticType instanceof \PHPStan\Type\ArrayType) {
            $return->expr = $thisRenderMethodCall;
        } elseif ($returnStaticType instanceof \PHPStan\Type\MixedType) {
            // nothing we can do
            return;
        }
        $isArrayOrResponseType = $this->arrayUnionResponseTypeAnalyzer->isArrayUnionResponseType($returnStaticType, self::RESPONSE_CLASS);
        if ($isArrayOrResponseType) {
            $this->processIsArrayOrResponseType($return, $lastReturnExpr, $thisRenderMethodCall);
        }
        $this->returnTypeDeclarationUpdater->updateClassMethod($classMethod, self::RESPONSE_CLASS);
        $this->removePhpDocTagValueNode($classMethod, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
    }
    private function processClassMethodWithoutReturn(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $classMethod->stmts[] = new \PhpParser\Node\Stmt\Return_($thisRenderMethodCall);
    }
    private function processIsArrayOrResponseType(\PhpParser\Node\Stmt\Return_ $return, \PhpParser\Node\Expr $returnExpr, \PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $this->removeNode($return);
        // create instance of Response → return response, or return $this->render
        $responseVariable = new \PhpParser\Node\Expr\Variable('responseOrData');
        $assign = new \PhpParser\Node\Expr\Assign($responseVariable, $returnExpr);
        $if = new \PhpParser\Node\Stmt\If_(new \PhpParser\Node\Expr\Instanceof_($responseVariable, new \PhpParser\Node\Name\FullyQualified(self::RESPONSE_CLASS)));
        $if->stmts[] = new \PhpParser\Node\Stmt\Return_($responseVariable);
        $thisRenderMethodCall->args[1] = new \PhpParser\Node\Arg($responseVariable);
        $returnThisRender = new \PhpParser\Node\Stmt\Return_($thisRenderMethodCall);
        $this->addNodesAfterNode([$assign, $if, $returnThisRender], $return);
    }
}
