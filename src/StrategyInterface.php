<?php

namespace Xu\Flow;

/**
 * Interface: StrategyInterface
 *
 * A strategy decides which process from a number of possible processes should be picked
 */
interface StrategyInterface
{
    /**
     * Pick next process
     *
     * @param mixed $factor
     * @param \Xu\Flow\ProcessInterface[] $processes
     *
     * @return \Xu\Flow\ProcessInterface|null
     */
    public function pickNextProcess($factor, $processes);
}
