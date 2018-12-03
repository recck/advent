<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day3 extends AbstractProblem
{
    private $board;

    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $lines = $this->filesystem->contentsAsArray($input[0]);

        $this->board = array_fill(0, 1000, array_fill(0, 1000, 0));

        foreach ($lines as $line) {
            $data = $this->squaresToFill($line);

            foreach ($data as $y => $xs) {
                foreach (array_keys($xs) as $x) {
                    $this->board[$y][$x]++;
                }
            }
        }

        echo 'part 1: ' . $this->squaresSeenMoreThanOnce() . PHP_EOL;
    }

    private function squaresToFill(string $line): array
    {
        preg_match('/^#\d+ @ (\d+),(\d+): (\d+)x(\d+)$/', trim($line), $matches);

        list(, $x, $y, $width, $height) = $matches;

        $return = [];

        for ($i = $x; $i < $x + $width; $i++) {
            for ($j = $y; $j < $y + $height; $j++) {
                $return[$j][$i] = true;
            }
        }

        return $return;
    }

    private function squaresSeenMoreThanOnce(): int
    {
        $seenGt1 = 0;

        foreach ($this->board as $row => $cols) {
            foreach ($cols as $col) {
                if ($col >= 2) {
                    $seenGt1++;
                }
            }
        }

        return $seenGt1;
    }

    private function printBoard()
    {
        foreach ($this->board as $row => $cols) {
            foreach ($cols as $col) {
                if ($col > 1) {
                    echo 'X';
                } else {
                    echo $col;
                }
            }

            echo PHP_EOL;
        }
    }
}