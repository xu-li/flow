<?php

namespace Xu\Flow;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\Workflow as SFWorkflow;
use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore as MarkingStore;

/**
 * Class: Flow
 */
class Flow
{
    /**
     * Current state
     *
     * @var string|null
     */
    protected $state;

    /**
     * @var ProcessRegistry
     */
    protected $registry;

    /**
     * @var StrategyInterface
     */
    protected $strategy;

    /**
     * @var \Symfony\Component\Workflow\Workflow
     */
    protected $workflow;

    /**
     * Constructor
     *
     * @param Definition $definition
     * @param ProcessRegistry $registry
     * @param StrategyInterface $strategy
     */
    public function __construct(
        Definition $definition,
        ProcessRegistry $registry,
        StrategyInterface $strategy = null,
        EventDispatcherInterface $dispatcher = null
    ) {
        $this->workflow = new SFWorkflow($definition, new MarkingStore('state'), $dispatcher);
        $this->registry = $registry;
        $this->state    = $definition->getInitialPlace();
        $this->strategy = $strategy ?: new DefaultStrategy;
    }

    /**
     * Proceed
     *
     * @param mixed $payload
     * @return mixed
     */
    public function proceed($payload = null)
    {
        do {
            $state = $this->getState();

            if (!$state) {
                break;
            }

            // get the process
            $process = $this->registry->get($state);
            
            if (!$process) {
                throw new ProcessNotFoundException($this, $state);
            }

            $result = $process->proceed($payload);

            // find all the candidates
            $candidates = [];
            foreach ($this->workflow->getEnabledTransitions($this) as $transition) {
                // ideally, there should be only one destination
                foreach ($transition->getTos() as $to) {
                    $candidate = $this->registry->get($to);

                    if (!$candidate) {
                        throw new ProcessNotFoundException($this, $to);
                    }

                    $candidates[$transition->getName()] = $candidate;
                }
            }

            // no more processes
            if (empty($candidates)) {
                break;
            }

            // pick next process
            $next = $this->strategy->pickNextProcess($result, array_values($candidates));

            if (!$next) {
                break;
            }

            // find the transition
            $transition = '';
            foreach ($candidates as $name => $candidate) {
                if ($candidate == $next) {
                    $transition = $name;
                    break;
                }
            }

            // apply the transition
            if ($transition) {
                $this->workflow->apply($this, $transition);
            }

        // bail if the state hasn't been changed
        } while ($state != $this->state);

        // return the payload
        return $payload;
    }

    /**
     * Get workflow
     *
     * @return \Symfony\Component\Workflow\Workflow
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * Get the current state
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the current state
     *
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
}
