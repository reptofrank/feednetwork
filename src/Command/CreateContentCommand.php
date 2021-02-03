<?php

namespace App\Command;

use App\Entity\Content;
use App\Entity\Feed;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateContentCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'create:content';

    private $em;

    function __construct(EntityManagerInterface $em) {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates feed content')
            ->setHelp('This command allows you to create new content for an existing feed')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        
        $feeds = $this->em->getRepository(Feed::class)->findTitles();
        
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion('Select feed - default [0]', array_column($feeds, 'title'), 0);
        $feedTitle = $helper->ask($input, $output, $question);

        $feed = $this->em->getRepository(Feed::class)->findOneBy(['title' => $feedTitle]);
        
        if($feed) {
            $title = $this->askQuestion($helper, $input, $output, 'Content title? ');
            $description = $this->askQuestion($helper, $input, $output, 'Content description? ');
            $guid = $this->askQuestion($helper, $input, $output, 'Content guid? ');
            // $pubdate = $this->askQuestion($helper, $input, $output, 'Content pubdate? (e.g. 01-01-2001) ');

            $content = new Content;
            $content->setTitle($title);
            $content->setDescription($description);
            $content->setGuid($guid);
            $content->setPubdate(new \DateTime());
            $content->setFeed($feed);

            $this->em->persist($content);
            $this->em->flush();
        }
        
        if ($feedTitle) {
            $output->writeln("$title created");
            return Command::SUCCESS;
        }
    }

    private function askQuestion($helper, $input, $output, $question)
    {
        $q = new Question($question);
        return $helper->ask($input, $output, $q);
    }
}