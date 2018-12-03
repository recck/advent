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

        $this->board = array_fill(0, self::DIM, array_fill(0, self::DIM, 0));

        foreach ($lines as $lineNum => $line) {
            $data = $this->squaresToFill($line);

            foreach ($data as $y => $xs) {
                foreach (array_keys($xs) as $x) {
                    $curVal = $this->board[$y][$x];

                    if ($curVal === 0) {
                        $this->board[$y][$x] = 'X' . ($lineNum + 1);
                    } elseif (strpos($curVal, 'X') === 0) {
                        $this->board[$y][$x] = 2;
                    } else {
                        $this->board[$y][$x]++;
                    }
                }
            }
        }

        echo 'part 1: ' . $this->squaresSeenMoreThanOnce() . PHP_EOL;
        echo 'part 2: ' . $this->getNonOverlapClaim($lines) . PHP_EOL;
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
                if ($col >= 2 && strpos($col, 'X') === false) {
                    $seenGt1++;
                }
            }
        }

        return $seenGt1;
    }

    private function getNonOverlapClaim(array $lines)
    {
        foreach ($lines as $lineNum => $line) {
            $data = $this->squaresToFill($line);
            $actualLineNum = $lineNum + 1;
            $toMatch = 'X' . $actualLineNum;
            $totalSquares = array_sum(array_map('count', $data));
            $matched = 0;

            foreach ($data as $y => $xs) {
                foreach (array_keys($xs) as $x) {
                    $curVal = $this->board[$y][$x];

                    if ($curVal === $toMatch) {
                        $matched++;
                    }
                }
            }

            if ($matched == $totalSquares) {
                return $actualLineNum;
            }
        }
    }

    private function printBoard()
    {
        foreach ($this->board as $row => $cols) {
            foreach ($cols as $col) {
                echo $col . "\t";
            }

            echo PHP_EOL;
        }
    }
}