<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    private $passwordEncoder;

    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $link = $this->getDoctrine()->getManager();
            var_dump($user->getPassword());exit;
            $user->setRoles(["ROLE_USER"]);
            $user->setCreated(new DateTime('now'));
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));

            $link->persist($user);
            $link->flush();
            $this->addFlash('correcto', 'Su registro fue exitoso.');
            return $this->redirectToRoute('registro');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario' => $form->createView()
        ]);
    }
}
