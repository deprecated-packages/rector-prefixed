<?php

namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\Fixture;

use _PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post;
use _PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response;
final class PostController extends \_PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController
{
    public function anythingAction(int $id) : \_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(\_PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post::class)->findSomething($id);
        return new \_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response();
    }
}
?>
-----
<?php 
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\Fixture;

use _PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post;
use _PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response;
final class PostController extends \_PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController
{
    /**
     * @var \Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Repository\PostRepository
     */
    private $postRepository;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Repository\PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function anythingAction(int $id) : \_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $this->postRepository->findSomething($id);
        return new \_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response();
    }
}
