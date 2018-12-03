<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day3 extends AbstractProblem
{
    const DIM = 1000;
    private $board;

    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $lines = $this->filesystem->contentsAsArray($input[0]);

        $this->board = array_fill(0, self::DIM, array_fill(0, self::DIM, []));

        foreach ($lines as $line) {
            $this->fillArea($line);
        }

        echo 'part 1: ' . $this->squaresSeenMoreThanOnce() . PHP_EOL;
        echo 'part 2: ' . $this->getNonOverlapClaim($lines) . PHP_EOL;
    }

    private function parseLine(string $line): array
    {
        preg_match('/^#(\d+) @ (\d+),(\d+): (\d+)x(\d+)$/', trim($line), $matches);

        return $matches;
    }

    private function fillArea(string $line)
    {
        list(, $lineNum, $x, $y, $width, $height) = $this->parseLine($line);

        for ($i = $x; $i < $x + $width; $i++) {
            for ($j = $y; $j < $y + $height; $j++) {
                $this->board[$j][$i][] = $lineNum;
            }
        }
    }

    private function squaresSeenMoreThanOnce(): int
    {
        $seenGt1 = 0;

        foreach ($this->board as $row => $cols) {
            foreach ($cols as $col) {
                if (count($col) > 1) {
                    $seenGt1++;
                }
            }
        }

        return $seenGt1;
    }

    private function getNonOverlapClaim(array $lines)
    {
        foreach ($lines as $line) {
            list(, $lineNum, $x, $y, $width, $height) = $this->parseLine($line);

            $cols = array_slice($this->board, $y, $height, true);
            $area = array_map(function ($col) use ($x, $width) {
                return array_slice($col, $x, $width, true);
            }, $cols);

            $flat = call_user_func_array('array_merge', $area);
            $count = array_sum(array_map('count', $flat));

            if ($count === ($width * $height)) {
                return $lineNum;
            }
        }
    }
}
