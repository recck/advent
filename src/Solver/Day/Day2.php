<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day2 extends AbstractProblem
{
    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $file = $this->filesystem->contentsAsArray($input[0]);

        $twos = 0;
        $threes = 0;

        foreach ($file as $line) {
            if ($this->hasExactlyNOfAnyLetter($line, 2)) {
                $twos++;
            }

            if ($this->hasExactlyNOfAnyLetter($line, 3)) {
                $threes++;
            }
        }

        echo 'part 1: ' . ($twos * $threes) . PHP_EOL;

        $commons = '';

        foreach ($file as $lineA) {
            foreach ($file as $lineB) {
                if ($lineA === $lineB) {
                    continue;
                }

                $diff = $this->characterDifferences($lineA, $lineB);

                if (count($diff) === 1) {
                    $char = $lineA[array_keys($diff)[0]];
                    $commons = str_replace($char, '', $lineA);

                    break 2;
                }
            }
        }

        echo 'part 2: ' . $commons . PHP_EOL;
    }

    private function hasExactlyNOfAnyLetter(string $line, int $n): bool
    {
        $counts = count_chars($line, 1);

        return in_array($n, $counts);
    }

    private function characterDifferences(string $a, string $b): array
    {
        $diff = [];

        for ($i = 0; $i < strlen($a); $i++) {
            if ($a[$i] != $b[$i]) {
                $diff[$i] = true;
            }
        }

        return $diff;
    }
}
