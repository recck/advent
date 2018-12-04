<?php

namespace Advent\Solver\Day;

use Advent\AbstractProblem;

class Day4 extends AbstractProblem
{
    private $sortedList;

    private $guardSchedule = [];

    private $sleepiestGuard;

    private $minutesSlept;

    /**
     * @param array $input
     * @return int|string
     */
    public function solve(array $input)
    {
        $lines = $this->filesystem->contentsAsArray($input[0]);

        $this->sortInput($lines);
        $this->createGuardSchedule();
        $this->guardWhoSleepsMost();
        list($sleepiestMinute,) = $this->getSleepiestMinute($this->sleepiestGuard);

        echo 'part 1: ' . ($sleepiestMinute * $this->sleepiestGuard) . PHP_EOL;
        echo 'part 2: ' . $this->getMostFrequentSleepyGuard() . PHP_EOL;
    }

    private function getMostFrequentSleepyGuard(): int
    {
        $maxOccurrence = -1;
        $frequentGuard = -1;
        $frequentMinute = -1;

        foreach (array_keys($this->guardSchedule) as $guard) {
            list($minute, $occurrences) = $this->getSleepiestMinute($guard);

            if ($occurrences > $maxOccurrence) {
                $maxOccurrence = $occurrences;
                $frequentGuard = $guard;
                $frequentMinute = $minute;
            }
        }

        return $frequentMinute * $frequentGuard;
    }

    private function getSleepiestMinute(int $guard): array
    {
        $guardSchedule = $this->guardSchedule[$guard];
        $minutes = [];

        foreach ($guardSchedule as $schedule) {
            $minutes = array_merge($minutes, array_keys($schedule));
        }

        $sortedMinutes = array_count_values($minutes);
        arsort($sortedMinutes);

        return [array_keys($sortedMinutes)[0] ?? -1, current($sortedMinutes)];
    }

    private function guardWhoSleepsMost()
    {
        $maxSleep = -1;
        $sleepiestGuard = 0;

        foreach ($this->guardSchedule as $guard => $schedules) {
            if (empty($schedules)) {
                continue;
            }

            $curSleep = count(call_user_func_array('array_merge', $schedules));

            if ($curSleep > $maxSleep) {
                $maxSleep = $curSleep;
                $sleepiestGuard = $guard;
            }
        }

        $this->sleepiestGuard = $sleepiestGuard;
        $this->minutesSlept = $maxSleep;
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