<?php

use Xu\Flow\ProcessInterface;

class DidYouFindIt implements ProcessInterface
{
    public function supports($name)
    {
        return $name == 'did_you_find_it';
    }

    public function proceed($payload)
    {
        $found = false;
        
        if ($payload->tried >= 3) {
            $found = true;
        }

        echo "Did you find it: " . ($found ? "Yes" : "No") . PHP_EOL;

        return $found;
    }
}
