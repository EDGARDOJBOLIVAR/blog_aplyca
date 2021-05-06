<?php

namespace App\Controller;

use App\Entity\BlogEntries;
use App\Form\BlogEntriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class BlogEntriesController extends AbstractController
{
    /**
     * @Route("/nueva-entrada", name="blog_entries")
     */
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $Entrada = new BlogEntries();
        $form = $this->createForm(BlogEntriesType::class, $Entrada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('image')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('images_blogs_entrities_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception("Error en la subida", 1);
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $Entrada->setImage($newFilename);
            }

            $link = $this->getDoctrine()->getManager();

            $Entrada->setUser($this->getUser());

            $link->persist($Entrada);
            $link->flush();
            // $this->addFlash('correcto', BlogEntriesType::REGISTRO_EXITOSO);
            return $this->redirectToRoute('blog');
        }

        return $this->render('blog_entries/index.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/ver-entrada/{entrada_id}", name="view_entries")
     */
    public function verEntrada($entrada_id): Response
    {
        $link = $this->getDoctrine()->getManager();
        $Entrada = $link->getRepository(BlogEntries::class)->find($entrada_id);

        return $this->render('blog_entries/ver_entrada.html.twig', [
            'entrada' => $Entrada
        ]);
    }
}
