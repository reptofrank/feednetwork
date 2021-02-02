<?php

namespace App\DataFixtures;

use App\Factory\ContentFactory;
use App\Factory\FeedFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 5 feeds
        FeedFactory::new()->createMany(5);

        // 
        ContentFactory::new()->createMany(
            50, 
            function() { 
                return ['feed' => FeedFactory::random()];
            }
        );
        $manager->flush();
    }
}
