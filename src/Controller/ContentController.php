<?php

namespace App\Controller;

use App\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $contents = $this->getDoctrine()->getRepository(Content::class)->findAll();

        return $this->render('content/index.html.twig', ['contents' => $contents]);
    }
}
