<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day6 extends AbstractProblem
{
    const DIM = 10;

    private $grid;

    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $vectorInput = $this->filesystem->contentsAsArray($input[0]);

        $vectors = [];

        foreach ($vectorInput as $vector) {
            list($x, $y) = explode(',', trim($vector));
            $vectors[] = [$x, $y];
        }

        $this->grid = array_fill(0, self::DIM, array_fill(0, self::DIM, -1));

        $this->populateGrid($vectors);
    }

    private function populateGrid(array $vectors)
    {
        foreach ($this->grid as $y => $cols) {
            foreach ($cols as $x => $value) {
                $coord = [$x, $y];
                $distances = [];

                foreach ($vectors as $i => $vector) {
                    $distance = $this->manhattan($coord, $vector);

                    $distances[$i] = $distance;
                }

                $values = array_count_values($distances);
                $min = min(array_keys($values));

                if ($values[$min] > 1) {
                    $this->grid[$y][$x] = '.';
                } else {
                    $this->grid[$y][$x] = array_flip($distances)[$min];
                }

                echo $this->grid[$y][$x];
            }
            echo PHP_EOL;
        }
    }

    private function manhattan($vectorA, $vectorB)
    {
        $n = count($vectorA);
        $sum = 0;

        for ($i = 0; $i < $n; $i++) {
            $sum += abs($vectorA[$i] - $vectorB[$i]);
        }

        return $sum;
    }
}