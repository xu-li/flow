<?php

namespace Xu\Flow;

/**
 * Class: DefaultStrategy
 *
 * A simple strategy class
 *
 * 1. If there is no processes, it returns null
 * 2. If there is only one process, it returns that process
 * 3. If there are two processes, it returns the first process if $factor is true.
 *    Otherwise, returns the second process
 * 4. If there are more than two processes, it returns the first process
 *
 * @see StrategyInterface
 */
class DefaultStrategy implements StrategyInterface
{
    /**
     * @inheritDoc
     */
    public function pickNextProcess($factor, $processes)
    {
        $total = count($processes);

        switch ($total) {
            case 0:
                return null;

            case 1:
                return current($processes);

            case 2:
                return $factor ? $processes[0] : $processes[1];

            default:
                return current($processes);
        }

        return null;
    }
}
