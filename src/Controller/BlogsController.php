<?php

namespace App\Controller;

use App\Entity\BlogEntries;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogsController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $link = $this->getDoctrine()->getManager();
        
        $Posts = $link->getRepository(BlogEntries::class)->buscarEntradasBlog();
        $pagination = $paginator->paginate(
            $Posts, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('blogs/index.html.twig', [
            'posts' => $Posts,
            'pagination' => $pagination
        ]);
    }
}
