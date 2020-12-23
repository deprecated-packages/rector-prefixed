<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Sensio\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Sensio\NodeFactory\ThisRenderFactory;
use _PhpScoper0a2ac50786fa\Rector\Sensio\TypeAnalyzer\ArrayUnionResponseTypeAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Sensio\TypeDeclaration\ReturnTypeDeclarationUpdater;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony-docs/pull/12387#discussion_r329551967
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/view.html
 * @see https://github.com/sensiolabs/SensioFrameworkExtraBundle/issues/641
 *
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector\TemplateAnnotationToThisRenderRectorTest
 */
final class TemplateAnnotationToThisRenderRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const RESPONSE_CLASS = '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpFoundation\\Response';
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Sensio\TypeAnalyzer\ArrayUnionResponseTypeAnalyzer $arrayUnionResponseTypeAnalyzer, \_PhpScoper0a2ac50786fa\Rector\Sensio\TypeDeclaration\ReturnTypeDeclarationUpdater $returnTypeDeclarationUpdater, \_PhpScoper0a2ac50786fa\Rector\Sensio\NodeFactory\ThisRenderFactory $thisRenderFactory)
    {
        $this->returnTypeDeclarationUpdater = $returnTypeDeclarationUpdater;
        $this->thisRenderFactory = $thisRenderFactory;
        $this->arrayUnionResponseTypeAnalyzer = $arrayUnionResponseTypeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `@Template` annotation to explicit method call in Controller of FrameworkExtraBundle in Symfony', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_|ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return $this->addAbstractControllerParentClassIfMissing($node);
        }
        return $this->replaceTemplateAnnotation($node);
    }
    private function addAbstractControllerParentClassIfMissing(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_
    {
        if ($class->extends !== null) {
            return null;
        }
        if (!$this->classHasTemplateAnnotations($class)) {
            return null;
        }
        $class->extends = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController');
        return $class;
    }
    private function replaceTemplateAnnotation(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$classMethod->isPublic()) {
            return null;
        }
        /** @var SensioTemplateTagValueNode|null $sensioTemplateTagValueNode */
        $sensioTemplateTagValueNode = $this->getPhpDocTagValueNode($classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
        if ($sensioTemplateTagValueNode === null) {
            return null;
        }
        $this->refactorClassMethod($classMethod, $sensioTemplateTagValueNode);
        return $classMethod;
    }
    private function classHasTemplateAnnotations(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            if ($this->hasPhpDocTagValueNode($classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class)) {
                return \true;
            }
        }
        return \false;
    }
    private function refactorClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : void
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
        $this->traverseNodesWithCallable($stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$returns) : ?int {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_) {
                return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $returns[] = $node;
            return null;
        });
        return $returns;
    }
    private function hasLastReturnResponse(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Return_|null $lastReturn */
        $lastReturn = $this->betterNodeFinder->findLastInstanceOf((array) $classMethod->stmts, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class);
        if ($lastReturn === null) {
            return \false;
        }
        return $this->isReturnOfObjectType($lastReturn, self::RESPONSE_CLASS);
    }
    private function refactorReturn(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode, bool $hasThisRenderOrReturnsResponse) : void
    {
        // nothing we can do
        if ($return->expr === null) {
            return;
        }
        // create "$this->render('template.file.twig.html', ['key' => 'value']);" method call
        $thisRenderMethodCall = $this->thisRenderFactory->create($classMethod, $return, $sensioTemplateTagValueNode);
        $this->refactorReturnWithValue($return, $hasThisRenderOrReturnsResponse, $thisRenderMethodCall, $classMethod);
    }
    private function refactorNoReturn(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $this->processClassMethodWithoutReturn($classMethod, $thisRenderMethodCall);
        $this->returnTypeDeclarationUpdater->updateClassMethod($classMethod, self::RESPONSE_CLASS);
        $this->removePhpDocTagValueNode($classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
    }
    private function refactorReturnWithValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return, bool $hasThisRenderOrReturnsResponse, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var Expr $lastReturnExpr */
        $lastReturnExpr = $return->expr;
        $returnStaticType = $this->getStaticType($lastReturnExpr);
        if (!$return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            if (!$hasThisRenderOrReturnsResponse || $returnStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
                $return->expr = $thisRenderMethodCall;
            }
        } elseif ($returnStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            $return->expr = $thisRenderMethodCall;
        } elseif ($returnStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            // nothing we can do
            return;
        }
        $isArrayOrResponseType = $this->arrayUnionResponseTypeAnalyzer->isArrayUnionResponseType($returnStaticType, self::RESPONSE_CLASS);
        if ($isArrayOrResponseType) {
            $this->processIsArrayOrResponseType($return, $lastReturnExpr, $thisRenderMethodCall);
        }
        $this->returnTypeDeclarationUpdater->updateClassMethod($classMethod, self::RESPONSE_CLASS);
        $this->removePhpDocTagValueNode($classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class);
    }
    private function processClassMethodWithoutReturn(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_($thisRenderMethodCall);
    }
    private function processIsArrayOrResponseType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $returnExpr, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $thisRenderMethodCall) : void
    {
        $this->removeNode($return);
        // create instance of Response → return response, or return $this->render
        $responseVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('responseOrData');
        $assign = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($responseVariable, $returnExpr);
        $if = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_($responseVariable, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(self::RESPONSE_CLASS)));
        $if->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_($responseVariable);
        $thisRenderMethodCall->args[1] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($responseVariable);
        $returnThisRender = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_($thisRenderMethodCall);
        $this->addNodesAfterNode([$assign, $if, $returnThisRender], $return);
    }
}
