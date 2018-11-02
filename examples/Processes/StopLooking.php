<?php

use Xu\Flow\ProcessInterface;

class StopLooking implements ProcessInterface
{
    public function supports($name)
    {
        return $name == 'stop_looking';
    }

    public function proceed($payload)
    {
        echo "Stop looking..." . PHP_EOL;
    }
}
