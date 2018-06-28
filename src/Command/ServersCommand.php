<?php

namespace Rsyncr\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServersCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('servers')
            ->setDescription('List the available servers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Servers');
    }
}