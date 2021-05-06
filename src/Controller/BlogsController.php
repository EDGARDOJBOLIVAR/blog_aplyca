<?php

namespace App\Controller;

use App\Entity\BlogEntries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogsController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $link = $this->getDoctrine()->getManager();
        
        $Posts = $link->getRepository(BlogEntries::class)->buscarEntradasBlog();

        return $this->render('blogs/index.html.twig', [
            'posts' => $Posts,
        ]);
    }
}
