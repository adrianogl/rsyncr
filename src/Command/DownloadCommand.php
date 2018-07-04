<?php

namespace Rsyncr\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('down')
            ->setDescription('Sync files remote to local.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Down');
    }
}