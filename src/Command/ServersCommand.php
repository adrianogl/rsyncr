<?php

namespace Rsyncr\Command;

use Rsyncr\Storage\Manager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class ServersCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('servers')
            ->setDescription('List the available servers.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = new Manager();
        $table = new Table($output);
        $table->setHeaders(['Alias', 'Host']);
        $servers = [];
        foreach ($manager->getConfiguration() as $server) {
            $servers[] = [
                $server['alias'], $server['host']
            ];
        }

        $table->setRows($servers);
        $table->render();
    }
}