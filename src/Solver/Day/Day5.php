<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day5 extends AbstractProblem
{
    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $string = $this->filesystem->contents($input[0]);
        $part1 = $this->react($string);

        echo 'part 1: ' . $part1 . PHP_EOL;

        $least = PHP_INT_MAX;
        $letter = null;

        foreach (range('a', 'z') as $i) {
            $testString = preg_replace('/' . $i . '/i', '', $string);
            $lengthOfReact = $this->react($testString);

            if ($lengthOfReact < $least) {
                $least = $lengthOfReact;
                $letter = $i;
            }
        }

        echo 'part 2: ' . $letter . ' produces a string of length ' . $least . PHP_EOL;
    }

    public function react(string $string): int
    {
        $len = strlen($string);
        $i = 1;

        while ($i < $len) {
            $a = $string[$i - 1];
            $b = $string[$i];

            if ($this->sameTypeDifferentCase($a, $b)) {
                $string = substr_replace($string, '', $i - 1, 2);
                $len -= 2;
                $i = max(1, $i - 2);

                continue;
            }

            $i++;
        }

        return strlen($string);
    }

    public function sameTypeDifferentCase(string $a, string $b): bool
    {
        $aL = strtolower($a);
        $bL = strtolower($b);

        if ($aL === $bL && $a !== $b) {
            return true;
        }

        return false;
    }
}