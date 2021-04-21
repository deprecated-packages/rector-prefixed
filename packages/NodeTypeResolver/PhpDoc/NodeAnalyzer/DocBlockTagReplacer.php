<?php

declare(strict_types=1);

namespace Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\BetterPhpDocParser\Annotation\AnnotationNaming;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;

final class DocBlockTagReplacer
{
    /**
     * @var AnnotationNaming
     */
    private $annotationNaming;

    public function __construct(AnnotationNaming $annotationNaming)
    {
        $this->annotationNaming = $annotationNaming;
    }

    /**
     * @return void
     */
    public function replaceTagByAnother(PhpDocInfo $phpDocInfo, string $oldTag, string $newTag)
    {
        $oldTag = $this->annotationNaming->normalizeName($oldTag);
        $newTag = $this->annotationNaming->normalizeName($newTag);

        $phpDocNode = $phpDocInfo->getPhpDocNode();
        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            if (! $phpDocChildNode instanceof PhpDocTagNode) {
                continue;
            }

            if ($phpDocChildNode->name !== $oldTag) {
                continue;
            }

            unset($phpDocNode->children[$key]);
            $phpDocNode->children[] = new PhpDocTagNode($newTag, new GenericTagValueNode(''));
        }
    }
}
