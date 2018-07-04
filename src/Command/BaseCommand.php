<?php

namespace Rsyncr\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

abstract class BaseCommand extends Command
{
    public $output;

    public function __construct($name = null, OutputInterface $output)
    {
        parent::__construct($name);
    }

    protected function info($text)
    {

        var_dump($text);
    }
}