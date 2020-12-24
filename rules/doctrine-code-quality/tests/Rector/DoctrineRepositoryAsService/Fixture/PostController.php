<?php

namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\Fixture;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response;
final class PostController extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController
{
    public function anythingAction(int $id) : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post::class)->findSomething($id);
        return new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response();
    }
}
?>
-----
<?php 
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\Fixture;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response;
final class PostController extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController
{
    /**
     * @var \Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Repository\PostRepository
     */
    private $postRepository;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Repository\PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function anythingAction(int $id) : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $this->postRepository->findSomething($id);
        return new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response();
    }
}
