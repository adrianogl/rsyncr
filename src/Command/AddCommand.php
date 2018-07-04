<?php

namespace Rsyncr\Command;

use Rsyncr\Servers\Manager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AddCommand extends Command
{
    protected $serverData;

    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Store a new connection configuration.')
            ->setDefinition(
                new InputDefinition(array(
                    new InputArgument('alias', InputArgument::OPTIONAL),
                ))
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serverData = [];

        $helper = $this->getHelper('question');
        $output->writeln('<info>Registering a new Server Configuration!</info>');
        $output->write(PHP_EOL);

        if ( ! $serverData['alias'] = $input->getArgument('alias')) {
            $question_alias      = new Question('<question>Server connection alias:</question>', false);
            $serverData['alias'] = $helper->ask($input, $output, $question_alias);
            if (trim($serverData['alias']) == '') {
                exit();
            }
        }

        $serverData['host'] = '127.0.0.1';

        $manager = new Manager();
        $manager->createServer($serverData);
        $output->writeln('<comment>Server registered successfully!</comment>');

    }
}