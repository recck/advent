<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

/**
 * You got rank 670 on this star's leaderboard.
 */
class Day1 extends AbstractProblem
{
    public function solve(array $input)
    {
        $file = $this->filesystem->contentsAsArray($input[0]);
        $steps = $this->cleanFrequencies($file);

        // part 1
        $part1 = $this->calculateFrequency($steps);

        echo 'part 1: ' . $part1 . PHP_EOL;

        // part 2
        $part2 = $this->determineFirstRepeatedFrequency($steps);

        echo 'part 2: ' . $part2 . PHP_EOL;
    }

    /**
     * @param array $steps
     * @param int $start
     * @return int
     */
    private function calculateFrequency(array $steps, $start = 0): int
    {
        return $start + array_sum($steps);
    }

    /**
     * @param array $steps
     * @return int|mixed
     */
    private function determineFirstRepeatedFrequency(array $steps)
    {
        $seen = [];
        $i = 0;
        $len = count($steps);
        $freq = 0;

        while (true) {
            $freq += $steps[$i % $len];

            if (in_array($freq, $seen)) {
                break;
            }

            $seen[] = $freq;
            $i++;
        }

        return $freq;
    }

    /**
     * @param array $steps
     * @return array
     */
    private function cleanFrequencies(array $steps): array
    {
        $steps = array_map(function ($step) {
            return str_replace('+', '', trim($step));
        }, $steps);

        return $steps;
    }
}
