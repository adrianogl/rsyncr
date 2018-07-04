<?php

namespace Rsyncr\Servers\Exceptions;

use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Exception\RuntimeException;

class NotFoundException extends RuntimeException implements ExceptionInterface
{

}