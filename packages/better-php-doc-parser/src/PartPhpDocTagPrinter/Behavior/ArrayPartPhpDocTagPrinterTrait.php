<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PartPhpDocTagPrinter\Behavior;

use RectorPrefix20210108\Nette\Utils\Json;
use RectorPrefix20210108\Nette\Utils\Strings;
use Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PartPhpDocTagPrinter\Behavior\ArrayPartPhpDocTagPrinterTest
 */
trait ArrayPartPhpDocTagPrinterTrait
{
    /**
     * @param mixed[] $item
     */
    public function printArrayItem(array $item, ?string $key, \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration $tagValueNodeConfiguration) : string
    {
        $content = \RectorPrefix20210108\Nette\Utils\Json::encode($item);
        // separate by space only items separated by comma, not in "quotes"
        $content = \RectorPrefix20210108\Nette\Utils\Strings::replace($content, '#,#', ', ');
        // @see https://regex101.com/r/C2fDQp/2
        $content = \RectorPrefix20210108\Nette\Utils\Strings::replace($content, '#("[^",]+)(\\s+)?,(\\s+)?([^"]+")#', '$1,$4');
        // change brackets from content to annotations
        $content = \RectorPrefix20210108\Nette\Utils\Strings::replace($content, '#^\\[(.*?)\\]$#', '{$1}');
        // cleanup content encoded extra slashes
        $content = \RectorPrefix20210108\Nette\Utils\Strings::replace($content, '#\\\\\\\\#', '\\');
        $content = $this->replaceColonWithEqualInSymfonyAndDoctrine($content, $tagValueNodeConfiguration);
        $keyPart = $this->createKeyPart($key, $tagValueNodeConfiguration);
        // should unquote
        if ($this->isValueWithoutQuotes($key, $tagValueNodeConfiguration)) {
            $content = \RectorPrefix20210108\Nette\Utils\Strings::replace($content, '#"#', '');
        }
        if ($tagValueNodeConfiguration->getOriginalContent() !== null && $key !== null) {
            $content = $this->quoteKeys($item, $key, $content, $tagValueNodeConfiguration->getOriginalContent());
        }
        return $keyPart . $content;
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
    private function replaceColonWithEqualInSymfonyAndDoctrine(string $content, \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration $tagValueNodeConfiguration) : string
    {
        return \RectorPrefix20210108\Nette\Utils\Strings::replace($content, '#(\\"|\\w)\\:(\\"|\\w)#', '$1' . $tagValueNodeConfiguration->getArrayEqualSign() . '$2');
    }
    private function createKeyPart(?string $key, \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration $tagValueNodeConfiguration) : string
    {
        if ($key === null) {
            return '';
        }
        if ($tagValueNodeConfiguration->isSilentKeyAndImplicit($key)) {
            return '';
        }
        return $key . '=';
    }
    private function isValueWithoutQuotes(?string $key, \Rector\BetterPhpDocParser\ValueObject\TagValueNodeConfiguration $tagValueNodeConfiguration) : bool
    {
        if ($key === null) {
            return \false;
        }
        if (!\array_key_exists($key, $tagValueNodeConfiguration->getKeysByQuotedStatus())) {
            return \false;
        }
        return !$tagValueNodeConfiguration->getKeysByQuotedStatus()[$key];
    }
    /**
     * @param mixed[] $item
     */
    private function quoteKeys(array $item, string $key, string $json, string $originalContent) : string
    {
        foreach (\array_keys($item) as $itemKey) {
            // @see https://regex101.com/r/V7nq5D/1
            $quotedKeyPattern = '#' . $key . '={(.*?)?\\"' . $itemKey . '\\"(=|:)(.*?)?}#';
            $isKeyQuoted = (bool) \RectorPrefix20210108\Nette\Utils\Strings::match($originalContent, $quotedKeyPattern);
            if (!$isKeyQuoted) {
                continue;
            }
            $json = \RectorPrefix20210108\Nette\Utils\Strings::replace($json, '#([^\\"])' . $itemKey . '([^\\"])#', '$1"' . $itemKey . '"$2');
        }
        return $json;
    }
}
