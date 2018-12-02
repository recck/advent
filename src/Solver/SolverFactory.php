<?php

namespace Advent\Solver;

use Advent\AbstractProblem;
use Advent\Util\Filesystem;

class SolverFactory
{
    /**
     * @param int $day
     * @return AbstractProblem
     */
    public static function create(int $day): AbstractProblem
    {
        $filesystem = new Filesystem();

        $className = 'Advent\Solver\Day\Day' . $day;

        if (class_exists($className)) {
            return new $className($filesystem);
        }

        throw new \RuntimeException('Day ' . $day . ' not implemented');
    }
}
