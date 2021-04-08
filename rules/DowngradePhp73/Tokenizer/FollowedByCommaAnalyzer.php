<?php

declare (strict_types=1);
namespace Rector\DowngradePhp73\Tokenizer;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use Rector\Core\Application\TokensByFilePathStorage;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class FollowedByCommaAnalyzer
{
    /**
     * @var TokensByFilePathStorage
     */
    private $tokensByFilePathStorage;
    public function __construct(\Rector\Core\Application\TokensByFilePathStorage $tokensByFilePathStorage)
    {
        $this->tokensByFilePathStorage = $tokensByFilePathStorage;
    }
    public function isFollowed(\PhpParser\Node $node) : bool
    {
        $smartFileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$smartFileInfo instanceof \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo) {
            return \false;
        }
        if (!$this->tokensByFilePathStorage->hasForFileInfo($smartFileInfo)) {
            return \false;
        }
        $parsedStmtsAndTokens = $this->tokensByFilePathStorage->getForFileInfo($smartFileInfo);
        $oldTokens = $parsedStmtsAndTokens->getOldTokens();
        $nextTokenPosition = $node->getEndTokenPos() + 1;
        while (isset($oldTokens[$nextTokenPosition])) {
            $currentToken = $oldTokens[$nextTokenPosition];
            // only space
            if (\is_array($currentToken) || \RectorPrefix20210408\Nette\Utils\Strings::match($currentToken, '#\\s+#')) {
                ++$nextTokenPosition;
                continue;
            }
            // without comma
            if ($currentToken === ')') {
                return \false;
            }
            break;
        }
        return \true;
    }
}
