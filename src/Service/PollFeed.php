<?php

namespace App\Service;

use App\Entity\Content;
use App\Entity\Feed;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class PollFeed
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * 
     */
    public function poll()
    {
        $feeds = $this->em->getRepository(Feed::class)->findAll();
        foreach ($feeds as $feed) {
            $data = self::read($feed->getUrl());
            if($data) {
                $this->storeFeed($data, $feed);
            }
        }
    }

    public function storeFeed($data)
    {

        $contents = $data['channel']['item'];
        
        foreach ($contents as $content) {
            $cnt = new Content;
            $cnt->setTitle($content['title']);
            $cnt->setDescription($content['description']);
            $cnt->setGuid($content['guid']);

            $this->em->persist($cnt);
        }

        $this->em->flush();
    }

    /**
     * Read data from feed urls
     * @param File $file 
     * @return array
     * @throws Exception if file format not supported
     */
    public static function read($url)
    {
        try {
            $content = file_get_contents($url);
        
            $xml = simplexml_load_string($content);
            $json = json_encode($xml);
            $data = json_decode($json,TRUE)['hotel'];
        } catch (\Exception $e) {
            return null;
        }

        return $data;
    }
}
