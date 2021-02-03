<?php

namespace App\DataFixtures;

use App\Factory\ContentFactory;
use App\Factory\FeedFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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
        // User
        UserFactory::new()->createOne(['email' => 'user@axelerant.com']);
        // Admin 
        UserFactory::new()->createOne(['email' => 'admin@axelerant.com']);
        

        $manager->flush();
    }
}
