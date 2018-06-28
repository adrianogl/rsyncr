<?php

namespace Rsyncr\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Store a new connection configuration.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Add');
    }
}