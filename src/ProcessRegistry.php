<?php

namespace Xu\Flow;

/**
 * Process registry class
 */
class ProcessRegistry
{
    /**
     * @var array
     */
    private $processes = [];

    /**
     * Add a process to this registry
     *
     * @param \Xu\Flow\ProcessInterface|\Xu\Flow\ProcessInterface[] $process
     * @param int $priority
     *
     * @return $this
     */
    public function add($process, $priority = 0)
    {
        // add multiple processes
        if (is_array($process)) {
            foreach ($process as $item) {
                $this->add($item);
            }

            return $this;
        }

        $this->processes[] = [$process, $priority];

        // sort by priority
        usort($this->processes, function ($a, $b) {
            return $a[1] <= $b[1];
        });

        return $this;
    }

    /**
     * Get a process from registry by name
     *
     * @param string $name The name of process
     *
     * @return \Xu\Flow\ProcessInterface|null
     */
    public function get($name)
    {
        foreach ($this->processes as list($process, $priority)) {
            if ($process->supports($name)) {
                return $process;
            }
        }

        return null;
    }

    /**
     * Get processes
     *
     * @return array
     */
    public function getProcesses()
    {
        $ret = [];

        foreach ($this->processes as list($process, $priority)) {
            $ret[] = $process;
        }

        return $ret;
    }
}
