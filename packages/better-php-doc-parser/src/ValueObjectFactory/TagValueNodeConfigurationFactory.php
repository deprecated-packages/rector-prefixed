<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObjectFactory;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Utils\ArrayItemStaticHelper;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration;
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
    public function createFromOriginalContent(?string $originalContent, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration
    {
        if ($originalContent === null) {
            return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration();
        }
        $silentKey = $this->resolveSilentKey($phpDocTagValueNode);
        $orderedVisibleItems = \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Utils\ArrayItemStaticHelper::resolveAnnotationItemsOrder($originalContent, $silentKey);
        $hasNewlineAfterOpening = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, self::NEWLINE_AFTER_OPENING_REGEX);
        $hasNewlineBeforeClosing = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, self::NEWLINE_BEFORE_CLOSING_REGEX);
        $hasOpeningBracket = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, self::OPENING_BRACKET_REGEX);
        $hasClosingBracket = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, self::CLOSING_BRACKET_REGEX);
        $keysByQuotedStatus = [];
        foreach ($orderedVisibleItems as $orderedVisibleItem) {
            $keysByQuotedStatus[$orderedVisibleItem] = $this->isKeyQuoted($originalContent, $orderedVisibleItem, $silentKey);
        }
        $isSilentKeyExplicit = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::contains($originalContent, \sprintf('%s=', $silentKey));
        $arrayEqualSign = $this->resolveArraySeparatorSign($originalContent, $phpDocTagValueNode);
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration($originalContent, $orderedVisibleItems, $hasNewlineAfterOpening, $hasNewlineBeforeClosing, $hasOpeningBracket, $hasClosingBracket, $keysByQuotedStatus, $silentKey, $isSilentKeyExplicit, $arrayEqualSign);
    }
    private function resolveSilentKey(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : ?string
    {
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface) {
            return $phpDocTagValueNode->getSilentKey();
        }
        return null;
    }
    private function isKeyQuoted(string $originalContent, string $key, ?string $silentKey) : bool
    {
        $escapedKey = \preg_quote($key, '#');
        $quotedKeyPattern = $this->createQuotedKeyPattern($silentKey, $key, $escapedKey);
        if ((bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, $quotedKeyPattern)) {
            return \true;
        }
        // @see https://regex101.com/r/VgvK8C/5/
        $quotedArrayPattern = \sprintf('#%s=\\{"(.*)"\\}|\\{"(.*)"\\}#', $escapedKey);
        return (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, $quotedArrayPattern);
    }
    private function resolveArraySeparatorSign(string $originalContent, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : string
    {
        $hasArrayColonSeparator = (bool) \_PhpScopere8e811afab72\Nette\Utils\Strings::match($originalContent, self::ARRAY_COLON_SEPARATOR_REGEX);
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
    private function resolveArrayEqualSignByPhpNodeClass(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : string
    {
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode) {
            return '=';
        }
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface) {
            return '=';
        }
        if ($phpDocTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode) {
            return '=';
        }
        return ':';
    }
}
