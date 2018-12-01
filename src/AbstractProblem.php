<?php

namespace Advent;

use Advent\Util\Filesystem;

abstract class AbstractProblem
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * AbstractProblem constructor.
     * @param Filesystem $filesystem
     */
    final public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param array $input
     * @return int|string
     */
    abstract public function solve(array $input);
}
