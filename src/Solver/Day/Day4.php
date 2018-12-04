<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day4 extends AbstractProblem
{
    private $sortedList;

    private $guardSchedule = [];

    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $lines = $this->filesystem->contentsAsArray($input[0]);

        $this->sortInput($lines);
        $this->createGuardSchedule();
    }

    private function createGuardSchedule()
    {
        $currentGuard = 0;
        $lastAsleep = 0;

        foreach ($this->sortedList as $time => $text) {
            preg_match('/^(.+) \d+:(\d{2})$/', $time, $timeMatches);
            list (, $date, $minute) = $timeMatches;

            if (preg_match('/\#(\d+)/', $text, $guardNum)) {
                $currentGuard = $guardNum[1];

                if (!array_key_exists($currentGuard, $this->guardSchedule)) {
                    $this->guardSchedule[$currentGuard] = [];
                }

                $this->guardSchedule[$currentGuard][$date] = array_fill(0, 59, false);
            } elseif ($text === 'falls asleep') {
                $lastAsleep = (int)$minute;
            } elseif ($text === 'wakes up') {
                for ($i = $lastAsleep; $i < (int)$minute; $i++) {
                    $this->guardSchedule[$currentGuard][$date][$i] = true;
                }
            }
        }
    }

    private function sortInput(array $lines)
    {
        $out = [];

        foreach ($lines as $i => $line) {
            preg_match('/^\[(.+)\] (.+)$/', trim($line), $matches);
            list(, $date, $text) = $matches;
            $date = str_replace('1518', '2018', $date);
            $out[$date] = $text;
        }

        uksort($out, function ($a, $b) {
            return strtotime($a) <=> strtotime($b);
        });

        $this->sortedList = $out;
    }
}