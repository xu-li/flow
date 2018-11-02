<?php

use Xu\Flow\ProcessInterface;

class LookForLostItem implements ProcessInterface
{
    public function supports($name)
    {
        return $name == 'look_for_lost_item';
    }

    public function proceed($payload)
    {
        $payload->tried++;

        echo "Looking for lost item ({$payload->tried})..." . PHP_EOL;
    }
}
