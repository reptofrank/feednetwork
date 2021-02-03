<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @Route("/feed", name="feed.index")
     */
    public function index(): Response
    {
        $feeds = $this->getDoctrine()->getRepository(Feed::class)->findAll();
        return $this->render('feed/index.html.twig', [
            'feeds' => $feeds,
        ]);
    }
    
    
    /**
     * Show feed's contents
     * @Route("/feed/{id}", name="feed.view", requirements={"id"="\d+"})
     */
    public function view(Feed $feed)
    {
        $contents = $this->getDoctrine()->getRepository(Content::class)->findBy(['feed' => $feed]);
        
        return $this->render('content/feed.html.twig', ['feed' => $feed, 'contents' => $contents]);
    }
    
    /**
     * @Route("/feed/add", name="feed.add", methods={"GET"})
     */
    public function add()
    {
        return $this->render('feed/add.html.twig');
    }
    
    
    /**
     * @return Response
     * @Route("/feed/store", name="feed.store", methods={"POST"})
     */
    public function store()
    {
        $feed = new Feed;
        $feed->setTitle($_POST['title']);
        $feed->setUrl($_POST['url']);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();
        
        return $this->redirectToRoute('feed.view', ['id' => $feed->getId()]);
    }

    /**
     * @Route("/feed/edit/{id}", name="feed.edit", methods={"GET"})
     */
    public function edit(Feed $feed)
    {
        return $this->render('feed/edit.html.twig', ['feed' => $feed]);
    }

    /**
     * Update feed URL and/or title
     * @Route("/feed/update/{id}", name="feed.update", methods={"POST"})
     */
    public function update(Feed $feed)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $feed->setTitle($_POST['title']);
        $feed->setUrl($_POST['url']);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('feed.view', ['id' => $feed->getId()]);
    }

    /**
     * Delete feed
     * @param Feed $feed
     * @return Response 
     * @Route("/feed/delete/{$id}", name="feed.delete", methods={"GET"})
     */
    public function delete(Feed $feed)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($feed);

        return $this->redirectToRoute('feed.show', ['feed' => $feed]);
    }


}
