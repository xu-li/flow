<?php

namespace Xu\Flow;

class ProcessNotFoundException extends \RuntimeException
{
    /**
     * @var \Xu\Flow\Flow
     */
    public $flow;


    /**
     * @var string
     */
    public $process;

    public function __construct(Flow $flow, $process, $message = "")
    {
        parent::__construct($message ?: "There is no process in the registry for {$process}.");

        $this->flow = $flow;
        $this->process = $process;
    }
}
