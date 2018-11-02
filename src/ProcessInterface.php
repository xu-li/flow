<?php

namespace Xu\Flow;

/**
 * Interface: ProcessInterface
 */
interface ProcessInterface
{
    /**
     * Supports?
     *
     * @param string $name The name of process
     *
     * @return bool
     */
    public function supports($name);

    /**
     * Proceed
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function proceed($payload);
}
