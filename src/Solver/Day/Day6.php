<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day6 extends AbstractProblem
{
    const DIM = 500;

    private $grid;

    private $vectors = [];

    private $vectorTotals = [];

    private $safeRegion = 0;

    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $vectorInput = $this->filesystem->contentsAsArray($input[0]);

        foreach ($vectorInput as $vector) {
            list($x, $y) = explode(',', trim($vector));
            $this->vectors[] = [$x, $y];
        }

        $this->grid = array_fill(0, self::DIM, array_fill(0, self::DIM, -1));

        $this->populateGrid();
        $vectorIdsOnEdge = $this->getEdges();
        arsort($this->vectorTotals);

        foreach ($this->vectorTotals as $id => $area) {
            if (!in_array($id, $vectorIdsOnEdge)) {
                echo 'part 1: ' . $id . ' has most area of ' . $area . PHP_EOL;
                break;
            }
        }

        echo 'part 2: ' . $this->safeRegion . PHP_EOL;
    }

    private function getEdges()
    {
        $topEdge = array_unique($this->grid[0]);
        $leftEdge = array_unique(array_column($this->grid, 0));
        $rightEdge = array_unique(array_column($this->grid, self::DIM - 1));
        $bottomEdge = array_unique($this->grid[self::DIM - 1]);

        return array_unique(array_merge(
            $topEdge,
            $leftEdge,
            $rightEdge,
            $bottomEdge
        ));
    }

    private function populateGrid()
    {
        foreach ($this->grid as $y => $cols) {
            foreach ($cols as $x => $value) {
                $coord = [$x, $y];
                $distances = [];
                $manhattamSums = 0;

                foreach ($this->vectors as $i => $vector) {
                    if (!array_key_exists($i, $this->vectorTotals)) {
                        $this->vectorTotals[$i] = 0;
                    }

                    $distance = $this->manhattan($coord, $vector);
                    $manhattamSums += $distance;

                    $distances[$i] = $distance;
                }

                $values = array_count_values($distances);
                $min = min(array_keys($values));

                if ($values[$min] > 1) {
                    $this->grid[$y][$x] = '.';
                } else {
                    $vectorId = array_flip($distances)[$min];
                    $this->grid[$y][$x] = $vectorId;
                    $this->vectorTotals[$vectorId]++;
                }

                if ($manhattamSums < 10000) {
                    $this->safeRegion++;
                }

                #echo $this->grid[$y][$x];
            }
            #echo PHP_EOL;
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