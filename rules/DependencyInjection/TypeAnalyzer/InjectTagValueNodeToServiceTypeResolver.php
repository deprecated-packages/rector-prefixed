<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\TypeAnalyzer;

use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode;
use Rector\Core\Exception\ShouldNotHappenException;
final class InjectTagValueNodeToServiceTypeResolver
{
    /**
     * @var JMSDITypeResolver
     */
    private $jmsdiTypeResolver;
    public function __construct(\Rector\DependencyInjection\TypeAnalyzer\JMSDITypeResolver $jmsdiTypeResolver)
    {
        $this->jmsdiTypeResolver = $jmsdiTypeResolver;
    }
    public function resolve(\PhpParser\Node\Stmt\Property $property, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PHPStan\PhpDocParser\Ast\Node $node) : \PHPStan\Type\Type
    {
        if ($node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode) {
            return $this->jmsdiTypeResolver->resolve($property, $node);
        }
        if ($node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPDI\PHPDIInjectTagValueNode) {
            return $phpDocInfo->getVarType();
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
}
