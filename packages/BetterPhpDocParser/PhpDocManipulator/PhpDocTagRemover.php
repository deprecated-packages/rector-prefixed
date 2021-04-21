<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\PhpDocManipulator;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;

final class PhpDocTagRemover
{
    /**
     * @return void
     */
    public function removeByName(PhpDocInfo $phpDocInfo, string $name)
    {
        $phpDocNode = $phpDocInfo->getPhpDocNode();

        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            if (! $phpDocChildNode instanceof PhpDocTagNode) {
                continue;
            }

            if ($this->areAnnotationNamesEqual($name, $phpDocChildNode->name)) {
                unset($phpDocNode->children[$key]);
                $phpDocInfo->markAsChanged();
            }

            if ($phpDocChildNode->value instanceof DoctrineAnnotationTagValueNode) {
                $tagClass = $phpDocChildNode->value->getAnnotationClass();
                if ($tagClass === $name) {
                    unset($phpDocNode->children[$key]);
                    $phpDocInfo->markAsChanged();
                }
            }
        }
    }

    /**
     * @return void
     */
    public function removeTagValueFromNode(PhpDocInfo $phpDocInfo, Node $desiredNode)
    {
        $phpDocNode = $phpDocInfo->getPhpDocNode();

        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            if ($phpDocChildNode === $desiredNode) {
                unset($phpDocNode->children[$key]);
                $phpDocInfo->markAsChanged();
                continue;
            }

            if (! $phpDocChildNode instanceof PhpDocTagNode) {
                continue;
            }

            if ($phpDocChildNode->value !== $desiredNode) {
                continue;
            }

            unset($phpDocNode->children[$key]);
            $phpDocInfo->markAsChanged();
        }
    }

    private function areAnnotationNamesEqual(string $firstAnnotationName, string $secondAnnotationName): bool
    {
        $firstAnnotationName = trim($firstAnnotationName, '@');
        $secondAnnotationName = trim($secondAnnotationName, '@');

        return $firstAnnotationName === $secondAnnotationName;
    }
}
