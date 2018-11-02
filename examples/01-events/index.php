<?php

include_once __DIR__ . "/../bootstrap.php";

use Xu\Flow\Flow;
use Xu\Flow\DefaultStrategy;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;


////////////////////////////////////////////
// Dispatcher                             //
////////////////////////////////////////////

$dispatcher = new EventDispatcher();
$dispatcher->addListener('workflow.completed', function (Event $event) {
    echo sprintf(">>> Completed transition %s to %s." . PHP_EOL . PHP_EOL, $event->getTransition()->getName(), $event->getSubject()->getState());
});

$flow = new Flow($definition, $registry, new DefaultStrategy, $dispatcher);
$flow->proceed((object) ['tried' => 0]);
