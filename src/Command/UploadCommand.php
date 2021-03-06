<?php

namespace Rsyncr\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('up')
            ->setDescription('Sync files local to remote.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Up');
    }
}