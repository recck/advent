<?php

namespace Advent\Solver;

use Advent\AbstractProblem;
use Advent\Solver\Day\Day1;
use Advent\Util\Filesystem;
use http\Exception\RuntimeException;

class SolverFactory
{
    /**
     * @param int $day
     * @return AbstractProblem
     */
    public static function create(int $day): AbstractProblem
    {
        $filesystem = new Filesystem();

        switch ($day) {
            case 1:
                return new Day1($filesystem);
                break;
            default:
                throw new RuntimeException('Day ' . $day . ' not implemented');
        }
    }
}
