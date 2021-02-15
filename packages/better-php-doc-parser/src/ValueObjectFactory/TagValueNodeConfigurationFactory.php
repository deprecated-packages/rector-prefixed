<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObjectFactory;

use RectorPrefix20210215\Nette\Utils\Strings;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use Rector\BetterPhpDocParser\Utils\ArrayItemStaticHelper;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration;
use RectorPrefix20210215\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @see \Rector\BetterPhpDocParser\Tests\ValueObjectFactory\TagValueNodeConfigurationFactoryTest
 */
final class TagValueNodeConfigurationFactory
{
    /**
     * @var string
     * @see https://regex101.com/r/y3U6s4/1
     */
    public const NEWLINE_AFTER_OPENING_REGEX = '#^(\\(\\s+|\\n)#m';
    /**
     * @var string
     * @see https://regex101.com/r/bopnKI/1
     */
    public const NEWLINE_BEFORE_CLOSING_REGEX = '#(\\s+\\)|\\n(\\s+)?)$#m';
    /**
     * @var string
     * @see https://regex101.com/r/IMT6GF/1
     */
    public const OPENING_BRACKET_REGEX = '#^\\(#';
    /**
     * @var string
     * @see https://regex101.com/r/nsFq7m/1
     */
    public const CLOSING_BRACKET_REGEX = '#\\)$#';
    /**
     * @var string
     * @see https://regex101.com/r/0KlSQv/1
     */
    public const ARRAY_COLON_SEPARATOR_REGEX = '#{([^{}]+)[:]([^{}]+)}#';
    /**
     * @var TypeChecker
     */
    private $typeChecker;
    public function __construct(\RectorPrefix20210215\Symplify\PackageBuilder\Php\TypeChecker $typeChecker)
    {
        $this->typeChecker = $typeChecker;
    }
    public function createFromOriginalContent(?string $originalContent, \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration
    {
        if ($originalContent === null) {
            return new \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration();
        }
        $silentKey = $this->resolveSilentKey($phpDocTagValueNode);
        $orderedVisibleItems = \Rector\BetterPhpDocParser\Utils\ArrayItemStaticHelper::resolveAnnotationItemsOrder($originalContent, $silentKey);
        $hasNewlineAfterOpening = (bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, self::NEWLINE_AFTER_OPENING_REGEX);
        $hasNewlineBeforeClosing = (bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, self::NEWLINE_BEFORE_CLOSING_REGEX);
        $hasOpeningBracket = (bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, self::OPENING_BRACKET_REGEX);
        $hasClosingBracket = (bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, self::CLOSING_BRACKET_REGEX);
        $keysByQuotedStatus = [];
        foreach ($orderedVisibleItems as $orderedVisibleItem) {
            $keysByQuotedStatus[$orderedVisibleItem] = $this->isKeyQuoted($originalContent, $orderedVisibleItem, $silentKey);
        }
        $isSilentKeyExplicit = \RectorPrefix20210215\Nette\Utils\Strings::contains($originalContent, \sprintf('%s=', $silentKey));
        $arrayEqualSign = $this->resolveArraySeparatorSign($originalContent, $phpDocTagValueNode);
        return new \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration($originalContent, $orderedVisibleItems, $hasNewlineAfterOpening, $hasNewlineBeforeClosing, $hasOpeningBracket, $hasClosingBracket, $keysByQuotedStatus, $silentKey, $isSilentKeyExplicit, $arrayEqualSign);
    }
    private function resolveSilentKey(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : ?string
    {
        if ($phpDocTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface) {
            return $phpDocTagValueNode->getSilentKey();
        }
        return null;
    }
    private function isKeyQuoted(string $originalContent, string $key, ?string $silentKey) : bool
    {
        $escapedKey = \preg_quote($key, '#');
        $quotedKeyPattern = $this->createQuotedKeyPattern($silentKey, $key, $escapedKey);
        if ((bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, $quotedKeyPattern)) {
            return \true;
        }
        // @see https://regex101.com/r/VgvK8C/5/
        $quotedArrayPattern = \sprintf('#%s=\\{"(.*)"\\}|\\{"(.*)"\\}#', $escapedKey);
        return (bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, $quotedArrayPattern);
    }
    private function resolveArraySeparatorSign(string $originalContent, \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : string
    {
        $hasArrayColonSeparator = (bool) \RectorPrefix20210215\Nette\Utils\Strings::match($originalContent, self::ARRAY_COLON_SEPARATOR_REGEX);
        if ($hasArrayColonSeparator) {
            return ':';
        }
        return $this->resolveArrayEqualSignByPhpNodeClass($phpDocTagValueNode);
    }
    private function createQuotedKeyPattern(?string $silentKey, string $key, string $escapedKey) : string
    {
        if ($silentKey === $key) {
            // @see https://regex101.com/r/VgvK8C/4/
            return \sprintf('#(%s=")|\\("#', $escapedKey);
        }
        // @see https://regex101.com/r/VgvK8C/3/
        return \sprintf('#%s="#', $escapedKey);
    }
    /**
     * Before:
     * (options={"key":"value"})
     *
     * After:
     * (options={"key"="value"})
     *
     * @see regex https://regex101.com/r/XfKi4A/1/
     *
     * @see https://github.com/rectorphp/rector/issues/3225
     * @see https://github.com/rectorphp/rector/pull/3241
     */
    private function resolveArrayEqualSignByPhpNodeClass(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : string
    {
        if ($this->typeChecker->isInstanceOf($phpDocTagValueNode, [\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class, \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface::class, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class])) {
            return '=';
        }
        return ':';
    }
}
