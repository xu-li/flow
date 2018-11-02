<?php

include_once __DIR__ . "/../vendor/autoload.php";
include_once __DIR__ . "/Processes/LookForLostItem.php";
include_once __DIR__ . "/Processes/DidYouFindIt.php";
include_once __DIR__ . "/Processes/StopLooking.php";

use Xu\Flow\Flow;
use Xu\Flow\ProcessRegistry;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;

////////////////////////////////////////////
// Registry                               //
////////////////////////////////////////////

$registry = new ProcessRegistry;
$registry->add(new LookForLostItem);
$registry->add(new DidYouFindIt);
$registry->add(new StopLooking);

////////////////////////////////////////////
// Definition                             //
////////////////////////////////////////////

$definition = (new DefinitionBuilder())->addPlaces([
        'look_for_lost_item', 
        'did_you_find_it',
        'stop_looking'
    ])

    // Transitions are defined with a unique name, an origin place and a destination place
    ->addTransition(new Transition('to-did_you_find_it',  'look_for_lost_item', 'did_you_find_it'))
    ->addTransition(new Transition('yes-did_you_find_it', 'did_you_find_it',    'stop_looking'))
    ->addTransition(new Transition('no-did_you_find_it',  'did_you_find_it',    'look_for_lost_item'))

    ->build();
