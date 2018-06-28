<?php

namespace Rsyncr\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('delete')
            ->setDescription('Remove a connection configuration.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Delete');
    }
}