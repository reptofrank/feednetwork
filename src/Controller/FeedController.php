<?php

namespace App\Controller;

use App\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    #[Route('/feed', name: 'feed.index')]
    public function index(): Response
    {
        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
        ]);
    }

    /**
     * @Route("/feed/add/{id}", name="feed.add", methods={"GET"})
     */
    public function add(Feed $feed = null)
    {
        return $this->render('feed/add.html.twig', ['feed' => $feed]);
    }

    /**
     * @Route("/feed/store", name="feed.store", methods={"POST"})
     */
    public function store()
    {
        $feed = new Feed;
        $feed->setTitle($_POST['title']);
        $feed->setSlug($this->slugify($_POST['title']));
        $feed->setUrl($_POST['url']);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();

        return $this->redirectToRoute('feed.show', ['feed' => $feed]);
    }

    /**
     * Update feed URL and/or title
     * @Route("/feed/update/{$id}", name="feed.update", methods={"POST"})
     */
    public function update(Feed $feed)
    {
        $feed->setTitle($_POST['title']);
        $feed->setUrl($_POST['url']);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('feed.show', ['feed' => $feed]);
    }

    /**
     * Delete feed
     * @Route("/feed/delete/{$id}", name="feed.delete", methods={"GET"})
     */
    public function delete(Feed $feed)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($feed);

        return $this->redirectToRoute('feed.show', ['feed' => $feed]);
    }

    /**
     * Slugify feed title
     *
     * A method that converts the title of a place to a slug
     *
     * @param String $title
     * @return String
     **/
    private function slugify(String $title)
    {
        $stripped = str_replace("  ", " ", preg_replace('(\/|\(|\))', "", $title));
        $slug = implode("-", explode(" ", strtolower($stripped)));

        return $slug;
    }


}
