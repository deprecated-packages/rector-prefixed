<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\Rector\BinaryOp;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\BinaryOp\ResponseStatusCodeRector\ResponseStatusCodeRectorTest
 */
final class ResponseStatusCodeRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const RESPONSE_CLASS = '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\Response';
    /**
     * @var string[]
     */
    private const CODE_TO_CONST = [100 => 'HTTP_CONTINUE', 101 => 'HTTP_SWITCHING_PROTOCOLS', 102 => 'HTTP_PROCESSING', 103 => 'HTTP_EARLY_HINTS', 200 => 'HTTP_OK', 201 => 'HTTP_CREATED', 202 => 'HTTP_ACCEPTED', 203 => 'HTTP_NON_AUTHORITATIVE_INFORMATION', 204 => 'HTTP_NO_CONTENT', 205 => 'HTTP_RESET_CONTENT', 206 => 'HTTP_PARTIAL_CONTENT', 207 => 'HTTP_MULTI_STATUS', 208 => 'HTTP_ALREADY_REPORTED', 226 => 'HTTP_IM_USED', 300 => 'HTTP_MULTIPLE_CHOICES', 301 => 'HTTP_MOVED_PERMANENTLY', 302 => 'HTTP_FOUND', 303 => 'HTTP_SEE_OTHER', 304 => 'HTTP_NOT_MODIFIED', 305 => 'HTTP_USE_PROXY', 306 => 'HTTP_RESERVED', 307 => 'HTTP_TEMPORARY_REDIRECT', 308 => 'HTTP_PERMANENTLY_REDIRECT', 400 => 'HTTP_BAD_REQUEST', 401 => 'HTTP_UNAUTHORIZED', 402 => 'HTTP_PAYMENT_REQUIRED', 403 => 'HTTP_FORBIDDEN', 404 => 'HTTP_NOT_FOUND', 405 => 'HTTP_METHOD_NOT_ALLOWED', 406 => 'HTTP_NOT_ACCEPTABLE', 407 => 'HTTP_PROXY_AUTHENTICATION_REQUIRED', 408 => 'HTTP_REQUEST_TIMEOUT', 409 => 'HTTP_CONFLICT', 410 => 'HTTP_GONE', 411 => 'HTTP_LENGTH_REQUIRED', 412 => 'HTTP_PRECONDITION_FAILED', 413 => 'HTTP_REQUEST_ENTITY_TOO_LARGE', 414 => 'HTTP_REQUEST_URI_TOO_LONG', 415 => 'HTTP_UNSUPPORTED_MEDIA_TYPE', 416 => 'HTTP_REQUESTED_RANGE_NOT_SATISFIABLE', 417 => 'HTTP_EXPECTATION_FAILED', 418 => 'HTTP_I_AM_A_TEAPOT', 421 => 'HTTP_MISDIRECTED_REQUEST', 422 => 'HTTP_UNPROCESSABLE_ENTITY', 423 => 'HTTP_LOCKED', 424 => 'HTTP_FAILED_DEPENDENCY', 425 => 'HTTP_TOO_EARLY', 426 => 'HTTP_UPGRADE_REQUIRED', 428 => 'HTTP_PRECONDITION_REQUIRED', 429 => 'HTTP_TOO_MANY_REQUESTS', 431 => 'HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE', 451 => 'HTTP_UNAVAILABLE_FOR_LEGAL_REASONS', 500 => 'HTTP_INTERNAL_SERVER_ERROR', 501 => 'HTTP_NOT_IMPLEMENTED', 502 => 'HTTP_BAD_GATEWAY', 503 => 'HTTP_SERVICE_UNAVAILABLE', 504 => 'HTTP_GATEWAY_TIMEOUT', 505 => 'HTTP_VERSION_NOT_SUPPORTED', 506 => 'HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL', 507 => 'HTTP_INSUFFICIENT_STORAGE', 508 => 'HTTP_LOOP_DETECTED', 510 => 'HTTP_NOT_EXTENDED', 511 => 'HTTP_NETWORK_AUTHENTICATION_REQUIRED'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns status code numbers to constants', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeController
{
    public function index()
    {
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setStatusCode(200);

        if ($response->getStatusCode() === 200) {}
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeController
{
    public function index()
    {
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);

        if ($response->getStatusCode() === \Symfony\Component\HttpFoundation\Response::HTTP_OK) {}
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param BinaryOp|MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return $this->processMethodCall($node);
        }
        return $this->processBinaryOp($node);
    }
    private function processMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        if (!$this->isObjectType($methodCall->var, self::RESPONSE_CLASS)) {
            return null;
        }
        if (!$this->isName($methodCall->name, 'setStatusCode')) {
            return null;
        }
        $statusCode = $methodCall->args[0]->value;
        if (!$statusCode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        if (!isset(self::CODE_TO_CONST[$statusCode->value])) {
            return null;
        }
        $classConstFetch = $this->createClassConstFetch(self::RESPONSE_CLASS, self::CODE_TO_CONST[$statusCode->value]);
        $methodCall->args[0] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($classConstFetch);
        return $methodCall;
    }
    private function processBinaryOp(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        if (!$this->isGetStatusMethod($binaryOp->left) && !$this->isGetStatusMethod($binaryOp->right)) {
            return null;
        }
        if ($binaryOp->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber && $this->isGetStatusMethod($binaryOp->left)) {
            $binaryOp->right = $this->convertNumberToConstant($binaryOp->right);
            return $binaryOp;
        }
        if ($binaryOp->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber && $this->isGetStatusMethod($binaryOp->right)) {
            $binaryOp->left = $this->convertNumberToConstant($binaryOp->left);
            return $binaryOp;
        }
        return null;
    }
    private function isGetStatusMethod(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isObjectType($node->var, self::RESPONSE_CLASS)) {
            return \false;
        }
        return $this->isName($node->name, 'getStatusCode');
    }
    /**
     * @return ClassConstFetch|LNumber
     */
    private function convertNumberToConstant(\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber $lNumber)
    {
        if (!isset(self::CODE_TO_CONST[$lNumber->value])) {
            return $lNumber;
        }
        return $this->createClassConstFetch(self::RESPONSE_CLASS, self::CODE_TO_CONST[$lNumber->value]);
    }
}
